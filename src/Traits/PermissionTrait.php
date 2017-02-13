<?php

namespace Hanson\Speedy\Traits;

use Speedy;

trait PermissionTrait
{
    public function role()
    {
        return $this->belongsTo(Speedy::getDefaultNamespace('role'));
    }

    public function permissions()
    {
        return $this->role->permissions();
    }

    /**
     * is user have permission
     *
     * @param $name
     * @return bool
     */
    public function hasPermission($name)
    {
        $userPermission = $this->permissions->pluck('name')->toArray();

        return in_array($name, $userPermission);
    }

    public function getMenus($json = false)
    {
        $menus = config('speedy.menus');
        $result = [];

        $permissions = $this->permissions->pluck('name')->toArray();

        foreach ($menus as $key => $menu) {
            if(isset($menu['sub']) && $menu['sub']){
                foreach ($menu['sub'] as $subKey => $subMenu) {
                    if(in_array("$key.sub.$subKey", $permissions)){
                        $result[$key]['display'] = config("speedy.menus.{$key}.display");
                        $result[$key]['sub'][$subKey] = config("speedy.menus.{$key}.sub.{$subKey}");
                    }
                }
            }else{
                if(in_array($key, $permissions)){
                    $result[$key] = $menu;
                }
            }
        }

        return $json ? json_encode($result, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) : $result;
    }

}