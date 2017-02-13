<?php

namespace Hanson\Speedy\Commands;

use Illuminate\Console\Command;
use Speedy;

class MenuCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'speedy:menu {--admin=admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recreate the menus and permissions from config(\'speedy.menus\').';

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
        $this->deleteRelation();

        $this->createPermission();

        if ($this->option('admin')) {
            $this->resetAdminPermission($this->option('admin'));
        }
    }

    public function deleteRelation()
    {
        $this->deletePermission();

        $this->deletePermissionRole();

        $this->info('relations have been deleted successful!');
    }

    public function deletePermission()
    {
        $permissions = Speedy::getModelInstance('permission')->all();

        foreach ($permissions as $permission) {
            if (!config("speedy.menus.{$permission->name}", null)) {
                Speedy::getModelInstance('permission_role')->where('permission_id', $permission->id)->delete();
                $permission->delete();
            }
        }
    }

    public function deletePermissionRole()
    {
        $permissionRoles = Speedy::getModelInstance('permission_role')->all();
        $role_ids = Speedy::getModelInstance('role')->all()->pluck('id')->toArray();

        $role_ids = $permissionRoles->pluck('role_id')->reject(function ($value, $key) use ($role_ids){
            return in_array($value, $role_ids);
        })->unique();

        Speedy::getModelInstance('permission_role')->whereIn('role_id', $role_ids)->delete();
    }

    public function createPermission()
    {
        foreach (config('speedy.menus') as $name => $menu) {
            if (isset($menu['sub']) && $menu['sub']) {
                foreach ($menu['sub'] as $subName => $subMenu) {
                    Speedy::getModelInstance('permission')->firstOrCreate(['name' => "{$name}.sub.{$subName}"], [
                        'name' => "{$name}.sub.{$subName}",
                        'display_name' => "{$subMenu['display']}",
                    ]);
                }
            } else {
                Speedy::getModelInstance('permission')->firstOrCreate(['name' => $name], [
                    'name' => $name,
                    'display_name' => "{$menu['display']}",
                ]);
            }
        }

        $this->info('permission have been created successful!');
    }

    public function resetAdminPermission($admin)
    {
        $role = Speedy::getModelInstance('role')->where([
            'name' => $admin,
        ])->first();

        if (!$role) {
            $this->error("{$admin} not found !");
            return;
        }

        $permissions = Speedy::getModelInstance('permission')->all();

        $role->permissions()->sync(
            $permissions->pluck('id')->all()
        );

        $this->info("{$admin} have add all the permissions!");
    }
}
