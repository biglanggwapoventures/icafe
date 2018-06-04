<?php

namespace App\Http\Controllers\Admin;

use App\CreditLog;
use App\Http\Controllers\BaseController;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Session;

class PurchaseCreditsController extends BaseController
{
    public function __construct(Request $request, CreditLog $model)
    {
        parent::__construct();

        $this->resourceModel = $model;

        $this->validationRules = [
            'store' => [
                'client_id' => [
                    'required',
                    Rule::exists('users', 'id')->where(function ($q) {
                        $q->whereRole('user');
                    }),
                ],
                'credit' => 'numeric|min:1',
            ],
        ];
    }

    public function beforeIndex($query)
    {
        Auth::user()->load('cafeAdmin');

        $query->with(['admin:id,name', 'cafeBranch:id,address'])
            ->where([
                ['cafe_branch_id', '=', data_get(Auth::user(), 'cafeAdmin.cafe_branch_id')],
                ['credit', '>', 0],
                ['debit', '<=', 0],
            ]);

        $this->viewData['userList'] = User::select('name', 'id')->whereRole('user')->pluck('name', 'id');
    }

    public function beforeStore()
    {
        Auth::user()->load('cafeAdmin');

        $this->validatedInput += [
            'cafe_branch_id' => data_get(Auth::user(), 'cafeAdmin.cafe_branch_id'),
            'loaded_by' => Auth::id(),
        ];
    }

    public function afterStore($model)
    {
        $model->load('client');

        Session::flash('load-success', "{$model->credit} credits has been successfully loaded to {$model->client->name}");
    }
}
