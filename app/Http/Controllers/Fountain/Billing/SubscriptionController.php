<?php

namespace App\Http\Controllers\Fountain\Billing;

use App\Http\Controllers\Controller;
use App\Services\Fountain\Billing;
use Auth;
use Laravel\Cashier\Subscription;
use Stripe\Plan;

class SubscriptionController extends Controller
{
    private $plans;

    public function __construct()
    {
        $this->plans = Plan::all(null, config('fountain.stripe.secret'))->data;
    }

    public function index()
    {
        // Redirect if no stripe account exists for current user
        if (Auth::user()->stripe_id == null) {
            return redirect()->route('fountain.billing.paymentmethod')->with('status', 'Please add a credit card.');
        }
        // Get Cards from Stripe
        $cards = Billing::getCards();

        $defaultCard = Billing::defaultCard();

        $currentPlan = Billing::currentPlanName();

        $planEnd = Billing::planEnd();

        return view('fountain.billing.subscription', ['plans' => $this->plans, 'defaultCard' => $defaultCard, 'currentPlan' => $currentPlan, 'planEnd' => $planEnd]);
    }

    public function changePlan($id)
    {
        $user = Auth::user();
        // check if user has any active subscription

        $currentPlan = Billing::currentPlanName();

        if ($currentPlan == null) {
            $user->newSubscription('main', $id)->create(null);
        } else {
            $user->subscription('main')->swap($id);
        }

        return redirect()->route('fountain.billing.subscriptionindex');
    }

    public function cancelPlan()
    {
        Auth::user()->subscription('main')->cancel();

        return redirect()->route('fountain.billing.subscriptionindex');
    }

    public function resumePlan()
    {
        Auth::user()->subscription('main')->resume();

        return redirect()->route('fountain.billing.subscriptionindex');
    }
}
