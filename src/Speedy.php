<?php
/**
 * Created by PhpStorm.
 * User: HanSon
 * Date: 2017/2/10
 * Time: 14:29
 */

namespace Hanson\Speedy;

use Auth;

class Speedy
{

    private static $instance;

    public static function getInstance()
    {
        if (!static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * get a model instance
     *
     * @param $key
     * @return mixed
     */
    public function getModelInstance($key)
    {
        $model = $this->getDefaultNamespace($key);
        return new $model;
    }

    /**
     * get a model namespace
     *
     * @param $key
     * @return string
     */
    public function getDefaultNamespace($key)
    {
        $config = config('speedy');

        $namespace = $config['class']['namespace'];

        $class = $config['class']['model'][$key];

        return $namespace . $class;
    }

    /**
     * get menu for current user
     *
     * @return string
     */
    public function getMenus()
    {
        return Auth::user() ? Auth::user()->getMenus(true) : json_encode([]);
    }

    /**
     * get a menu key from given url
     *
     * @param $url
     * @return bool|int|string
     */
    public function getKeyFromUrl($url)
    {
        foreach (config('speedy.menus') as $name => $menu) {
            if (isset($menu['url']) && $menu['url'] === $url) {
                return $name;
            } else {
                if (isset($menu['sub']) && is_array($menu['sub'])) {
                    foreach ($menu['sub'] as $subName => $subMenu) {
                        if (isset($subMenu['url']) && $subMenu['url'] === $url) {
                            return "{$name}.sub.{$subName}";
                        }
                    }
                }
            }


        }

        return false;
    }

}