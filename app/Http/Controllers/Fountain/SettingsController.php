<?php

namespace App\Http\Controllers\Fountain;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index()
    {
        return view('fountain.settings.index');
    }

    /**
     * update user name and email from client side
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //Get the logged in user
        $user = Auth::user();

        $this->validate($request, [
            'name'     => 'required|max:225',
            'email'    => 'required|unique:users,email,'.$user->id,
        ]);

        $user->name  = $request->input('name');
        $user->email = $request->input('email');

        $user->save();

        return response()->json(['status' => 'success', 'reply' => 'Your contact information has been updated.']);
    }

    /**
     * update user avatar
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeAvatar(Request $request)
    {
        //Get the logged in user
        $user = Auth::user();

        $this->validate($request, [
            'avatar'     => 'max:500|mimes:jpeg,png|dimensions:max_width=512,max_height=512',
        ]);

        $user->avatar = $request->file('avatar')->store('avatars', 'public');

        $user->save();

        return response()->json(['status' => 'success', 'location' => $user->avatar]);
    }

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

        return view('fountain.settings.paymentmethod', ['cards' => $cards, 'defaultCard' => $defaultCard]);
    }

    public function paymentMethodUpdate(Request $request)
    {
        $user = Auth::user();
        
        // Get stripe token for credit card
        $stripeToken = $request->input('stripeToken');
        // update default credit card for user
        $user->updateCard($stripeToken);

        return redirect()->route('fountain.settings.paymentmethod')->with('status', 'Your credit card has been updated');
    }

    public function defaultPaymentMethod($card)
    {
        // retrieve stripe customer
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $cu = \Stripe\Customer::retrieve(Auth::user()->stripe_id);
        $cu->default_source = $card;
        $cu->save();

        return redirect()->route('fountain.settings.paymentmethod')->with('status', 'Your default credit card has been updated');
    }
}
