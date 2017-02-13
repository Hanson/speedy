<?php

namespace Hanson\Speedy\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'speedy:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Speedy Admin package';

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
        $this->call('migrate');
        $this->call('speedy:model');
        $this->call('db:seed', [
            '--class' => 'Hanson\\Speedy\\Seeder\\SpeedySeeder'
        ]);
        $this->call('speedy:menu');
        $this->call('speedy:route');
    }
}
