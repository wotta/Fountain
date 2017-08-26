<?php

namespace App\Http\Controllers\Fountain\Billing;

use App\Http\Requests\Fountain\Admin\CreateStripePlanRequest;
use App\Http\Controllers\Controller;
use Laravel\Cashier\Subscription;
use Illuminate\Http\Request;
use Stripe\Plan;
use Auth;

class SubscriptionController extends Controller
{
    private $plans;

    public function __construct()
    {
        $this->plans = Plan::all(null, config('fountain.stripe.secret'))->data;
    }

    public function index()
    {
        // Get Cards from Stripe
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $cards = \Stripe\Customer::retrieve(Auth::user()->stripe_id);
        // convert stripe collection to array
        $cards = $cards->__toArray(true);
        // set default card
        $defaultCard = $cards['default_source'];

        return view('fountain.billing.subscription', ['plans' => $this->plans, 'defaultCard' => $defaultCard]);
    }

    public function changePlan($id)
    {
        $user = Auth::user();
        // check if user has any active subscription
        if ($user->subscription() == null) {
            // set the stripe token to null because it will use their default payment method.
            $user->newSubscription('main', $id)->create(null);
        } else {
            $user->subscription('main')->swap($id);
        }

        return redirect()->route('fountain.billing.subscriptionindex');
    }
}
