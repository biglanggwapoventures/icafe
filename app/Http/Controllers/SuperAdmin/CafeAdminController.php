<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Cafe;
use App\CafeAdmin;
use App\CafeBranch;
use App\Http\Controllers\BaseController;
use App\User;
use Illuminate\Http\Request;

class CafeAdminController extends BaseController
{
    protected $request;
    protected $resourceModel;

    public function __construct(CafeAdmin $model, Request $request)
    {
        parent::__construct();

        $this->resourceModel = $model;
        $this->request = $request;

        $this->validationRules = [
            'store' => [
                'cafe_branch_id' => 'required|exists:cafe_branches,id',
                'user.name' => 'required|string',
                'user.email' => 'required|email',
                'user.password' => 'required|string|min:4|confirmed',
                'user.password_confirmation' => 'required|same:user.password',
                'user.address' => 'required|string',
                'user.contact_number' => 'required|digits:11',
            ],
            'update' => [
                'cafe_branch_id' => 'required|exists:cafe_branches,id',
                'user.id' => 'required|exists:users,id',
                'user.name' => 'required|string',
                'user.email' => 'required|email|unique:users,email,' . $this->request->input('user.id'),
                'user.password' => 'nullable|string|min:4|confirmed',
                'user.password_confirmation' => 'nullable|same:user.password',
                'user.address' => 'required|string',
                'user.contact_number' => 'required|digits:11',
            ],
        ];
    }

    public function beforeCreate()
    {
        $cafes = Cafe::select('name', 'id')->orderBy('name')->pluck('name', 'id');

        $branches = CafeBranch::select('address', 'id', 'cafe_id')
            ->get()
            ->groupBy('cafe_id')
            ->mapWithKeys(function ($cafe, $id) {
                return [$id => $cafe->pluck('address', 'id')];
            });

        $this->viewData += compact('cafes', 'branches');
    }

    public function beforeEdit($model)
    {
        $model->load(['cafeBranch', 'user']);
        $this->beforeCreate();
    }

    public function beforeStore()
    {
        $input = ($this->request->user += ['role' => 'admin']);

        $user = User::create($input);

        $this->validatedInput['user_id'] = $user->id;
    }

    public function beforeUpdate()
    {
        $input = $this->request->user;
        $id = $input['id'];

        if (empty($input['password'])) {
            unset($input['password'], $input['password_confirmation']);
        }

        unset($input['id']);

        $user = User::whereId($id)->update($input);
    }

}
