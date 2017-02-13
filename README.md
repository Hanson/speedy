# Speedy

## Introduce

Speedy is a Laravel admin package build with bootstrap and vue, it contains a sidebar menu , a authentication and 
a authorization control

## Install

In your laravel application, execute the following command:

`composer require hanson/speedy`

add service provider to the app.php:

```
    'providers' => [
        // Laravel Framework Service Providers...
        //...
    
        // Package Service Providers
        Hanson\Speedy\SpeedyServiceProvider::class,
        // ...
    
        // Application Service Providers
        // ...
    ]
```

publish resource:

`php artisan vendor:publish --provider="Hanson\Speedy\SpeedyServiceProvider"`

after that, you might want to change some config about speedy:

```
// config/speedy.php
return [
    'class' => [
        'namespace' => 'App\\Models\\',
        'model' => [
            'role' => 'Role',
            'user' => 'User',
            'permission' => 'Permission',
            'permission_role' => 'PermissionRole',
        ]
    ],

    'table' => [
        'role' => 'role',
        'permission' => 'permission',
        'user' => 'user',
        'permission_role' => 'permission_role',
    ],
    // ...
]
```

By default, models will be storage to `App/Models`, and user table is `user`, or you can modify the config wherever you want

```
    'class' => [
        'namespace' => 'App\\Models\\',
        // 'namespace' => 'App\\', set model namespace as 'App\\'
        // ...
    ],
    'table' => [
        'user' => 'user',
        // 'user' => 'users', set user table name to users
    ]
```

__if you are using `user` as your table name, remember to modify the user's migration__

install speedy:

`php artisan speedy:install`

create a new admin user

`php artisan speedy:admin admin@email.com  --create`

or assign admin to an existing user

`php artisan speedy:admin admin@email.com `

make auth by default

`php artisan make:auth`

Start up a built-in development server, with `php artisan serve`, visit [http://localhost:8000/admin](http://localhost:8000/admin).

## Menu And Permission

Speedy sidebar Menus is a very convenient component, you just need to modify the speedy config and run a command to recreate the menu.

Speedy Permission is simple, it can't deal with complicated situation. Each single menu have a permission to control it. Which mean whoever can see this menu can access everything in it.    

```
    # speedy.php
    'menus' => [
        'user' => [
            'display' => 'User',
            'url' => '/admin/user'
        ],
        'role' => [
            'display' => 'Role',
            'url' => '/admin/role'
        ],
        'about' => [
            'display' => 'About HanSon',
            'sub' => [
                'github' => [
                    'display' => 'HanSon\'s Github',
                    'url' => 'https://github.com/hanson',
                    'target' => '_blank'
                ],
                'blog' => [
                    'display' => 'HanSon\'s Blog',
                    'url' => 'http://hanc.cc'
                ]
            ]
        ],
    ]
```

After modify the menu, run `php artisan speedy:menu` to recreate the menu and permission.

## Role

Every user has one role. Speedy user `admin` as a default role and own every permission, even though you modify the menu and run the recreate menu command.

## Middleware

Speedy provider a middleware name `speedy.auth` in `Hanson\Speedy\Http\Middleware\SpeedyAdminMiddleware`, every admin route must add it to keep application save.

`Hanson\Speedy\Http\Controllers\BaseController` will add middleware automatic.

```
protected $permissionName;

public function __construct()
{
    $this->middleware('speedy.auth:' . $this->permissionName);
}
```

You can make your admin controller extends `Hanson\Speedy\Http\Controllers\BaseController` and set `$permissionName` as the menu key.

## Validate

Speedy has separate the validate rule in `config/validator`, in the controller, you can use method `$validator = $this->mustValidate('{model}.{method}');` to validate the data. The error will display as you define by `resources/lang/en/attributre`.

## View

The blade file will be publish in `resources/views/vendor/speedy`, and you might want to change the resource link in `resources/views/vendor/speedy/layouts/app.blade.php`


 
