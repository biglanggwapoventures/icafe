<?php

namespace App\Http\Controllers\User;

use App\CafeBranch;
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

class FloorLayoutController extends Controller
{
    public function index($cafeBranchId)
    {
        $cafeBranch = CafeBranch::select('id', 'address', 'cafe_id')->with('cafe:id,name')->find($cafeBranchId);
        $coordinates = FloorPlan::of($cafeBranchId)->formattedCoordinates();
        return view('user.floor-plan', compact('coordinates', 'cafeBranchId', 'cafeBranch'));
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
        $reservationEnd = $reservationStart->addHours($input['duration_in_hours']);

        if (PCReservation::hasConflict($input['reservation_date'], $reservationStart, $reservationEnd)) {
            throw ValidationException::withMessages([
                'reservation_time' => ['Conflict'],
            ]);
        }

        $input['user_id'] = Auth::id();

        DB::beginTransaction();

        $reservation = PCReservation::create($input);
        $reservation->deductCredits();

        DB::commit();

        return response()->json([
            'result' => true,
        ]);
    }
}
