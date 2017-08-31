<?php

namespace App\Providers\Fountain;

use Illuminate\Support\ServiceProvider;
use Stripe\Plan;

class StripePlanServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('services.stripe.secret') && !cache()->get('fountain:plans')) {
            $plans = Plan::all(null, config('fountain.stripe.secret'));

            cache()->put('fountain:plans', collect($plans->data), 60);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
