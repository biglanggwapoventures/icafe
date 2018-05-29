<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class UpdateProfileController extends Controller
{
    public function __invoke(Request $request)
    {
        $input = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'contact_number' => 'required|digits:11',
            'address' => 'required|string',
            'password' => 'nullable|confirmed',
            'password_confirmation' => 'nullable|same:password',
        ]);

        if (!empty($input['password'])) {
            unset($input['password'], $input['password_confirmation']);
        }

        Auth::user()->update($input);

        return response()->json([
            'result' => true,
        ]);
    }
}
