<?php

namespace App\Http\Controllers\SuperAdmin;

use App\CafeBranch;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    public function topCafes()
    {

        $data = CafeBranch::top();
        $branches = CafeBranch::with('cafe:id,name')->get()->keyBy('id');
        return view('super-admin.reports.top-cafes', [
            'data' => $data,
            'branches' => $branches,
        ]);
    }
}
