<?php

namespace App\Http\Controllers\Fountain\Billing;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Fountain\Billing;

class PaymentController extends Controller
{
    public function paymentMethod()
    {
        // see if user has a stripe id
        if (Auth::user()->stripe_id == null) {
            Billing::createAccount();
        }

        $cards = Billing::getCards();

        $defaultCard = Billing::defaultCard();

        return view('fountain.billing.paymentmethod', ['cards' => $cards, 'defaultCard' => $defaultCard]);
    }

    public function paymentMethodAdd(Request $request)
    {
        $user = Auth::user();

        // Get stripe token for credit card
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $stripeToken = $request->input('stripeToken');

        // Add new card to user account
        $customer = \Stripe\Customer::retrieve($user->stripe_id);
        $customer->sources->create(array("source" => $stripeToken));

        return redirect()->route('fountain.billing.paymentmethod')->with('status', 'Your credit card has been added.');
    }

    public function defaultPaymentMethod($card)
    {
        // retrieve stripe customer
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $cu = \Stripe\Customer::retrieve(Auth::user()->stripe_id);
        $cu->default_source = $card;
        $cu->save();

        return redirect()->route('fountain.billing.paymentmethod')->with('status', 'Your default credit card has been updated');
    }
}
