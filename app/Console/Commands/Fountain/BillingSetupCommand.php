<?php

namespace App\Console\Commands\Fountain;

use Illuminate\Console\Command;
use Larapack\ConfigWriter\Repository;

class BillingSetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fountain:billing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup the billing information for fountain';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->companyQuestions();

        if ($this->confirm('Would you like to setup stripe?')) {
            $this->stripeQuestions();
        }
    }

    /**
     * Ask for the company information.
     */
    protected function companyQuestions()
    {
        $name = $this->ask('What is your company name?');

        $this->saveCompanyName($name);
    }

    /**
     * Save the company name to the configuriation file.
     *
     * @param $name
     */
    protected function saveCompanyName($name)
    {
        $config = new Repository('fountain');

        $config->set('company', $name);

        $config->save();
    }

    /**
     * Ask for the stripe key and secret.
     */
    protected function stripeQuestions()
    {
        $key = $this->ask('What is your stripe key? (begins with \'pk_live\')');

        $secret = $this->ask('What is your stripe secret? (begins with \'sk_live\')');

        $this->validateStripeQuestions($key, $secret);
    }


    /**
     * Check if the stripe key and secret are test keys.
     *
     * @param $key
     * @param $secret
     */
    protected function validateStripeQuestions($key, $secret)
    {
        if (! str_contains($key, ['pk', 'live']) || ! str_contains($secret, ['sk', 'live'])) {
            $this->error('Something went wrong with your key(s), please try again.');

            return $this->stripeQuestions();
        }

        return $this->saveStripeCredentials($key, $secret);
    }

    /**
     * Save the stripe credentials to the environment file.
     *
     * @param $key
     * @param $secret
     */
    protected function saveStripeCredentials($key, $secret)
    {
        file_put_contents($this->laravel->environmentFilePath(), str_replace(
            [
                'STRIPE_KEY=' . $this->laravel['config']['fountain.stripe.key'],
                'STRIPE_SECRET=' . $this->laravel['config']['fountain.stripe.secret']
            ],
            [
                'STRIPE_KEY=' . $key,
                'STRIPE_SECRET=' . $secret
            ],
            file_get_contents($this->laravel->environmentFilePath())
        ));
    }
}
