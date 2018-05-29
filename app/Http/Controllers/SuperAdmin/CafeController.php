<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Cafe;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class CafeController extends BaseController
{
    protected $request;
    protected $resourceModel;
    protected $relatedModel;

    public function __construct(Cafe $model, Request $request)
    {
        parent::__construct();

        $this->resourceModel = $model;
        $this->relatedModel = 'branches';
        $this->request = $request;

        $this->validationRules = [
            'store' => [
                'parent.name' => 'required|string',
                'child.*.address' => 'required|string',
                'child.*.latitude' => 'nullable|numeric',
                'child.*.longitude' => 'nullable|numeric',
                'child.*.contact_number' => 'required|string',
            ],
            'update' => [
                'parent.name' => 'required|string',
                'child.*.id' => 'sometimes|exists:cafe_branches',
                'child.*.address' => 'required|string',
                'child.*.latitude' => 'nullable|numeric',
                'child.*.longitude' => 'nullable|numeric',
                'child.*.contact_number' => 'required|string',
            ],
        ];
    }

    public function beforeIndex($query)
    {
        $query->with([
            'admins:cafe_admins.id as cafe_admin_id,user_id,cafe_branch_id',
            'admins.cafeBranch:id,address,contact_number',
            'admins.user:id,name,contact_number',
        ]);
    }
}
