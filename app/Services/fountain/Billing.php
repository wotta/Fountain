<?php

namespace App\Services\Fountain;

use Auth;

class Billing
{
    public static function defaultCard()
    {
        // set stripe key
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $cards = \Stripe\Customer::retrieve(Auth::user()->stripe_id);
        // convert stripe collection to array
        $cards = $cards->__toArray(true);
        // set default card
        $defaultCard = $cards['default_source'];

        return $defaultCard;
    }

    public static function getCards()
    {
        // set stripe key
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $cards = \Stripe\Customer::retrieve(Auth::user()->stripe_id);
        // convert stripe collection to array
        $cards = $cards->__toArray(true);

        return $cards;
    }

    public function createAccount()
    {
        // set stripe key
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        //get user
        $user = Auth::user();

        $stripeCreate = \Stripe\Customer::create(array(
              "email" => $user->email
            ));

        // update user stripe id in database
        $user->stripe_id = $stripeCreate['id'];

        $user->save();
    }
}
