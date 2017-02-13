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
        $menus = [];
        $permissions = $this->permissions->toArray();

        foreach ($permissions as $permission) {
            if(count(explode('.', $permission['name'])) > 1){
                list($name, , $subName) = explode('.', $permission['name']);
                $menus[$name]['display'] = config("speedy.menus.{$name}.display");
                $menus[$name]['sub'][$subName] = config("speedy.menus.{$name}.sub.{$subName}");
            }else{
                $menus[$permission['name']] = config("speedy.menus.{$permission['name']}");
            }
        }

        return $json ? json_encode($menus, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) : $menus;
    }

}