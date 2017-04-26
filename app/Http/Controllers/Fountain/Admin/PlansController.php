<?php

namespace App\Http\Controllers\Fountain\Admin;

use App\Http\Requests\Fountain\Admin\CreateStripePlanRequest;
use App\Http\Controllers\Controller;
use Laravel\Cashier\Subscription;
use Stripe\Plan;

class PlansController extends Controller
{
    /**
     * List of stripe plans.
     *
     * @var mixed
     */
    private $plans;

    /**
     * PlansController constructor.
     */
    public function __construct()
    {
        $this->plans = Plan::all(null, config('fountain.stripe.secret'))->data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('fountain.admin.plans.index', ['plans' => $this->plans]);
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

        Plan::create($request->except('_token'), config('fountain.stripe.secret'));

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
        $plan = collect($this->plans)->where('id', '=', $id)->first();

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

        return redirect()->route('fountain.admin.plans.index');
    }
}