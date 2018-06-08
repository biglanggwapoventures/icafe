<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        return redirect()->route('super-admin.cafe.index');
    }
}
