<?php

namespace App\Http\Controllers\Fountain\Admin;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('fountain.admin.index');
    }
}
