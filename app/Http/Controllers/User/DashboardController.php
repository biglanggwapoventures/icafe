<?php

namespace App\Http\Controllers\User;

use App\CafeBranch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $search = $request->q;

        $query = CafeBranch::when(trim($search), function ($q) use ($search) {
            return $q->search($search);
        }, function ($q) {
            return $q->with('cafe');
        });

        return view('user.dashboard', [
            'cafeBranches' => $query->get(),
        ]);
    }
}
