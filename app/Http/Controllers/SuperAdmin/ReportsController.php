<?php

namespace App\Http\Controllers\SuperAdmin;

use App\CafeBranch;
use App\CreditLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

    public function creditPointsList(Request $request)
    {
        $branches = CafeBranch::select('address', 'cafe_id', 'id')->with('cafe:id,name')->get();

        $data = [];

        if ($request->branch_id) {
            $data = CreditLog::whereCafeBranchId($request->branch_id)
                ->with('client:id,name')
                ->where('credit', '>', 0)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('super-admin.reports.credit-points-list', [
            'data' => $data,
            'branches' => $branches,
        ]);
    }

    public function personalUsageHistory(Request $request)
    {
        $branches = CafeBranch::select('address', 'cafe_id', 'id')->with('cafe:id,name')->get();

        $data = [];

        if ($request->branch_id) {
            $data = CreditLog::whereCafeBranchId($request->branch_id)
                ->with(['client:id,name', 'reservation:id,reservation_date,reservation_time,duration_in_hours'])
                ->where('debit', '>', 0)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('super-admin.reports.personal-usage-history', [
            'data' => $data,
            'branches' => $branches,
        ]);
    }
}
