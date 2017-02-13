<?php

namespace Hanson\Speedy\Commands;

use Speedy;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class AdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'speedy:admin {email} {--create}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make sure there is a user with the admin role that has all of the necessary permissions.';

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
        $user = $this->getUser($this->option('create'));

        // Get or create role
        $role = $this->getAdministratorRole();

        // Get all permissions
        $permissions = Speedy::getModelInstance('permission')->all();

        // Assign all permissions to the admin role
        $role->permissions()->sync(
            $permissions->pluck('id')->all()
        );

        // Ensure that the user is admin
        $user->role_id = $role->id;
        $user->save();

        $this->info('The user now has full access to your site.');
    }


    /**
     * Get command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['email', InputOption::VALUE_REQUIRED, 'The email of the user.', null],
        ];
    }


    protected function getAdministratorRole()
    {
        $role = Speedy::getModelInstance('role')->firstOrNew([
            'name' => 'admin',
        ]);

        if (!$role->exists) {
            $role->fill([
                'display_name' => 'Administrator',
            ])->save();
        }

        return $role;
    }

    protected function getUser($create = false)
    {
        $email = $this->argument('email');

        $model = Speedy::getModelInstance('user');

        // If we need to create a new user go ahead and create it
        if ($create) {
            $name = $this->ask('Enter the admin name');
            $password = $this->secret('Enter admin password');
            $this->info('Creating admin account');

            return $model::create([
                'name'             => $name,
                'email'            => $email,
                'password'         => \Hash::make($password),
            ]);
        }

        return $model::where('email', $email)->firstOrFail();
    }
}
