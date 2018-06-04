<?php

namespace App\Http\Controllers\SuperAdmin;

use App\CafeBranch;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    public function topCafes()
    {
        $data = CafeBranch::top()->get();
        return view('super-admin.reports.top-cafes', [
            'data' => $data,
        ]);
    }
}
