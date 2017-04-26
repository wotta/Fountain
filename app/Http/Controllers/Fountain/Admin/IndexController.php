<?php

namespace App\Http\Controllers\Fountain\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('fountain.admin.index');
    }
}
