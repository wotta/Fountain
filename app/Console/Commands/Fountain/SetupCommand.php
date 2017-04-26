<?php

namespace App\Console\Commands\Fountain;

use Illuminate\Console\Command;

class SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fountain:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup and configure fountain';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('fountain:billing');

        $this->info('Setup is complete.');
    }
}
