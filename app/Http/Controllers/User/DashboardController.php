<?php

namespace App\Http\Controllers\User;

use App\CafeBranch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $cafeBranches = CafeBranch::with('cafe')->get();
        return view('user.dashboard', compact('cafeBranches'));
    }
}
