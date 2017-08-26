<?php

namespace App\Http\Controllers\Fountain\Billing;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function paymentMethod()
    {
        //get user
        $user = Auth::user();

        // retrieve stripe cards for user
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        // see if user has a stripe id
        if ($user->stripe_id == null) {

            $stripeCreate = \Stripe\Customer::create(array(
              "email" => $user->email
            ));

            // update user stripe id in database
            $user->stripe_id = $stripeCreate['id'];

            $user->save();
        }

        $cards = \Stripe\Customer::retrieve(Auth::user()->stripe_id);
        // convert stripe collection to array
        $cards = $cards->__toArray(true);
        // set default card
        $defaultCard = $cards['default_source'];

        return view('fountain.billing.paymentmethod', ['cards' => $cards, 'defaultCard' => $defaultCard]);
    }

    public function paymentMethodUpdate(Request $request)
    {
        $user = Auth::user();

        // Get stripe token for credit card
        $stripeToken = $request->input('stripeToken');
        // update default credit card for user
        $user->updateCard($stripeToken);

        return redirect()->route('fountain.billing.paymentmethod')->with('status', 'Your credit card has been updated');
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
