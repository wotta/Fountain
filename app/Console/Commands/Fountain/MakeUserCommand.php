<?php

namespace App\Console\Commands\Fountain;

use App\User;
use Illuminate\Console\Command;

class MakeUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fountain:make-user {email} {--name=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user based on the email supplied';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $emailAddress = $this->argument('email');
        $name = $this->option('name') ? $this->option('name') : $emailAddress;

        if (User::where('email', $emailAddress)->count() > 0) {
            $this->error('Email Address already exists');

            return;
        }

        $this->info('Creating user for: '.$emailAddress);
        $password = str_random(8);

        User::create([
            'name'     => $name,
            'email'    => $emailAddress,
            'password' => bcrypt($password),
        ]);

        $this->info('Password has been set to: '.$password);
        $this->info('Finished');
    }
}
