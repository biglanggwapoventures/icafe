<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\PCReservation;
use Auth;
use Illuminate\Http\Request;

class ReservationHistoryController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = PCReservation::with(['pc:id,name,cafe_branch_id', 'pc.cafeBranch:id,address,cafe_id', 'pc.cafeBranch.cafe:id,name'])
            ->of(Auth::id())
            ->latest()
            ->get();

        return view('user.reservation-history', [
            'data' => $data,
        ]);
    }
}
