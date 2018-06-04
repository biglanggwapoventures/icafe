<?php

namespace App\Http\Controllers\Admin;

use App\FloorPlan;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    public function index(Request $request)
    {
        Auth::user()->load('cafeAdmin');

        $cafeBranchId = data_get(Auth::user(), 'cafeAdmin.cafe_branch_id');

        $coordinates = FloorPlan::of($cafeBranchId)->formattedCoordinates();

        return view('admin.reservations.index', compact('coordinates', 'cafeBranchId'));
    }
}
