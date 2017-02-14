<?php

namespace Hanson\Speedy\Commands;

use Illuminate\Console\Command;

class RouteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'speedy:route';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a default route to web.php';

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
        $route = file_get_contents(__DIR__ . '/../stubs/route.stub');
        file_put_contents(base_path('app/Http/routes.php'), $route, FILE_APPEND);
    }
}
