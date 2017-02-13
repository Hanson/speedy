<?php

namespace Hanson\Speedy\Seeder;

use Speedy;
use Illuminate\Database\Seeder;

class SpeedySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Speedy::getModelInstance('role')->firstOrCreate(['name' => 'admin',], ['display_name' => 'administrator',]);

        foreach(config('speedy.menus') as $name => $menu){
            if(isset($menu['sub']) && $menu['sub']){
                foreach ($menu['sub'] as $subName => $subMenu) {
                    Speedy::getModelInstance('permission')->firstOrCreate(['name' => "{$name}.sub.{$subName}"],[
                        'name' => "{$name}.sub.{$subName}",
                        'display_name' => "{$subMenu['display']}",
                    ]);
                }
            }else{
                Speedy::getModelInstance('permission')->firstOrCreate(['name' => $name],[
                    'name' => $name,
                    'display_name' => "{$menu['display']}",
                ]);
            }
        }
    }
}
