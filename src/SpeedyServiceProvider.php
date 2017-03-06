<?php
/**
 * Created by PhpStorm.
 * User: HanSon
 * Date: 2017/2/10
 * Time: 13:34
 */

namespace Hanson\Speedy;

use Hanson\Speedy\Http\Middleware\SpeedyRoleMiddleware;
use Illuminate\Routing\Router;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use Hanson\Speedy\Http\Middleware\SpeedyAdminMiddleware;

class SpeedyServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('speedy', function () {
            return new Speedy();
        });

        $loader = AliasLoader::getInstance();
        $loader->alias('Speedy', SpeedyFacade::class);

        $this->registerPublishableResources();
        $this->registerConsoleCommands();
    }

    /**
     * Bootstrap the application services.
     *
     * @param \Illuminate\Routing\Router $router
     * @param \Illuminate\Contracts\Events\Dispatcher $event
     */
    public function boot(Router $router, Dispatcher $event)
    {
        if (app()->version() >= 5.4) {
            $router->aliasMiddleware('speedy.auth', SpeedyAdminMiddleware::class);
            $router->aliasMiddleware('speedy.role', SpeedyRoleMiddleware::class);
        } else {
            $router->middleware('speedy.auth', SpeedyAdminMiddleware::class);
            $router->middleware('speedy.role', SpeedyRoleMiddleware::class);
        }
    }

    public function registerPublishableResources()
    {
        $prefix = __DIR__ . '/publishable';
        $this->publishes([$prefix . '/assets/' => public_path()]);
        $this->publishes([$prefix . '/database/' => database_path()]);
        $this->publishes([$prefix . '/config/' => config_path()]);
        $this->publishes([$prefix . '/resources/' => resource_path()]);
    }

    private function registerConsoleCommands()
    {
        $this->commands(Commands\ModelCommand::class);
        $this->commands(Commands\MenuCommand::class);
        $this->commands(Commands\AdminCommand::class);
        $this->commands(Commands\RouteCommand::class);
        $this->commands(Commands\InstallCommand::class);
    }

}

