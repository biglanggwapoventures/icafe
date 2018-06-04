<?php

namespace App\Http\Controllers\Admin;

use App\FloorPlan;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FloorLayoutController extends Controller
{
    protected $cafeBranchId = null;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->cafeBranchId = Auth::user()->cafeAdmin->cafe_branch_id;
            return $next($request);
        });
    }

    public function index()
    {
        $coordinates = FloorPlan::whereCafeBranchId($this->cafeBranchId)
            ->get()
            ->groupBy('y')
            ->mapWithKeys(function ($xCoordinates, $y) {
                return [$y => $xCoordinates->keyBy('x')];
            });

        return view('admin.floor-layout', compact('coordinates'));
    }

    public function store(Request $request)
    {
        $input = $request->validate([
            'x' => 'required|integer',
            'y' => 'required|integer',
            // 'cafe_branch_id' => $branch,
            'name' => 'required|string',
        ]);

        $input['cafe_branch_id'] = $this->cafeBranchId;

        FloorPlan::create($input);

        return response()->json([
            'result' => true,
        ]);

    }

    public function update(Request $request)
    {
        $input = $request->validate([
            'id' => [
                'nullable',
                Rule::exists('floor_plans')->where(function ($q) {
                    return $q->whereCafeBranchId($this->cafeBranchId);
                }),
            ],
            'name' => [
                'required',
                Rule::unique('floor_plans')->ignore($request->id)->where(function ($q) {
                    return $q->whereCafeBranchId($this->cafeBranchId);
                }),
            ],
            'status' => 'required|in:available,unavailable,removed',
        ]);

        FloorPlan::whereId($input['id'])
            ->when($input['status'] === 'removed', function ($q) use ($input) {
                $q->delete();
            }, function ($q) use ($input) {
                $q->update(['status' => $input['status'], 'name' => $input['name']]);
            });

        return response()->json([
            'result' => true,
        ]);
    }
}
