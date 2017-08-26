<?php

namespace App\Http\Controllers\Fountain\Billing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('fountain.billing.subscription');
    }
}
