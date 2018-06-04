<?php

namespace App\Http\Controllers\User;

use App\CreditLog;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class CreditHistoryController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = CreditLog::of(Auth::id())->get();

        return view('user.credit-history', [
            'data' => $data,
        ]);
    }
}
