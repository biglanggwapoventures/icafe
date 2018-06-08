<?php

namespace App\Http\Controllers\User;

use App\CafeBranch;
use App\Facades\SMS;
use App\FloorPlan;
use App\Http\Controllers\Controller;
use App\PCReservation;
use App\Rules\CreditBalance;
use App\Rules\MinHalfHour;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator;

class FloorLayoutController extends Controller
{
    public function index($cafeBranchId, Request $request)
    {
        $cafeBranch = CafeBranch::select('id', 'address', 'cafe_id')
            ->with('cafe:id,name')
            ->find($cafeBranchId);

        $query = FloorPlan::of($cafeBranchId);

        $validator = Validator::make($request->all(), [
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required|date_format:H:i',
            'duration_in_hours' => ['required', 'numeric' /*, new MinHalfHour, 'min:1', new CreditBalance*/],
        ]);

        // set defaults
        $reservationDate = date('Y-m-d');
        $reservationTime = date('H:i');
        $duration = 0;

        // change params
        if ($validator->passes()) {
            $reservationDate = $request->reservation_date;
            $reservationTime = $request->reservation_time;
            $duration = $request->duration_in_hours;
        }

        // dd()

        $data = $query->withReservationsOn($reservationDate)
            ->get()
            ->each(function ($pc) use ($reservationTime, $duration) {
                $pc->conflicts = $pc->flagConflict(
                    Carbon::parse($reservationTime),
                    Carbon::parse($reservationTime)->addHours($duration)
                );
            })
            ->groupBy('y')
            ->mapWithKeys(function ($xCoords, $yValue) {
                return [$yValue => $xCoords->keyBy('x')];
            });

        return view('user.floor-plan', [
            'coordinates' => $data,
            'cafeBranchId' => $cafeBranchId,
            'cafeBranch' => $cafeBranch,
            'reservationDate' => $reservationDate,
            'reservationTime' => $reservationTime,
            'duration' => $duration,
        ]);
    }

    public function reserve($cafeBranchId, Request $request)
    {
        $input = $request->validate([
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required|date_format:H:i',
            'duration_in_hours' => ['required', 'numeric', new MinHalfHour, 'min:1', new CreditBalance],
            'floor_plan_id' => 'required|exists:floor_plans,id',
        ]);

        $reservationStart = Carbon::parse($input['reservation_time']);
        $reservationEnd = $reservationStart->copy()->addHours($input['duration_in_hours']);

        $pc = FloorPlan::with('cafeBranch.cafe')
            ->withReservationsOn($input['reservation_date'])
            ->find($input['floor_plan_id']);

        if ($pc->flagConflict($reservationStart, $reservationEnd)) {
            throw ValidationException::withMessages([
                'reservation_time' => ['Conflict'],
            ]);
        }

        $input['user_id'] = Auth::id();

        DB::beginTransaction();

        $reservation = PCReservation::create($input);
        $reservation->deductCredits();

        $body = sprintf("PC # %s from %s to %s on %s", $pc->name, $reservationStart->format('h:i a'), $reservationEnd->format('h:i a'), $pc->cafeBranch->cafe->name);
        $message = new SMS(Auth::user()->contact_number, $body);
        $message->send();

        DB::commit();

        return response()->json([
            'result' => true,
        ]);
    }
}
