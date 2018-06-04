<?php
namespace App\Http\Controllers;

use App\FloorPlan as PC;
use App\Http\Controllers\Controller;
use Auth;

class GetTodaysReservationsController extends Controller
{
    public function __invoke(PC $pc)
    {
        $pc->load('todaysReservations');

        if (Auth::user()->is('user')) {
            return view('user.ajax-todays-reservation', compact('pc'));
        }

        $pc->load('todaysReservations.user');
        return view('admin.ajax-todays-reservation', compact('pc'));
    }
}
