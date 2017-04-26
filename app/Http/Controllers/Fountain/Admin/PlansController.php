<?php

namespace App\Http\Controllers\Fountain\Admin;

use App\Http\Requests\Fountain\Admin\CreateStripePlanRequest;
use App\Http\Controllers\Controller;
use Laravel\Cashier\Subscription;
use Stripe\Plan;

class PlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = cache()->get('fountain:plans');

        return view('fountain.admin.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fountain.admin.plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateStripePlanRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateStripePlanRequest $request)
    {
        $request->merge([
            'id' => str_slug($request->name),
            'amount' => is_float($request->amount) ? str_replace('.', '', $request->amount) : $request->amount * 100,
            'currency' => config('fountain.stripe.currency')
        ]);

        Plan::create($request->except('_token'), config('services.stripe.secret'));

        cache()->forget('fountain:plans');

        return redirect()->route('fountain.admin.plans.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plan = cache()->get('fountain:plans')->where('id', '=', $id)->first();

        $subscriptions = Subscription::where('stripe_plan', '=', $id)->get();

        return view('fountain.admin.plans.show', compact('plan', 'subscriptions'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Plan::retrieve($id, config('fountain.stripe.secret'))->delete();

        cache()->forget('fountain:plans');

        return redirect()->route('fountain.admin.plans.index');
    }
}
