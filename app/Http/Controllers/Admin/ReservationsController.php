<?php

namespace App\Http\Controllers\Admin;

use App\FloorPlan;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    public function index(Request $request)
    {
        Auth::user()->load('cafeAdmin');

        $cafeBranchId = data_get(Auth::user(), 'cafeAdmin.cafe_branch_id');

        $reservationDate = date('Y-m-d');
        $reservationTime = date('H:i');
        $duration = 0;

        $coordinates = FloorPlan::of($cafeBranchId)
            ->withReservationsOn($reservationDate)
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

        return view('admin.reservations.index', [
            'coordinates' => $coordinates,
            'cafeBranchId' => $cafeBranchId,
        ]);
    }
}
