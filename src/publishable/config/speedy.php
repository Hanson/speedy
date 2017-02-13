<?php

return [

    /**
     * -----------------------------------------------------------------------------------------------------------------
     *  Models config
     * -----------------------------------------------------------------------------------------------------------------
     *
     * config your namespace and model's Class name
     *
     */

    'class' => [
        'namespace' => 'App\\Models\\',
        'model' => [
            'role' => 'Role',
            'user' => 'User',
            'permission' => 'Permission',
            'permission_role' => 'PermissionRole',
        ]
    ],

    /**
     * -----------------------------------------------------------------------------------------------------------------
     *  Table config
     * -----------------------------------------------------------------------------------------------------------------
     *
     * config your table name
     *
     */

    'table' => [
        'role' => 'role',
        'permission' => 'permission',
        'user' => 'users',
        'permission_role' => 'permission_role',
    ],

    /**
     * -----------------------------------------------------------------------------------------------------------------
     *  Menus config
     * -----------------------------------------------------------------------------------------------------------------
     *
     * config your sidebar menu here
     *
     */

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
        'favorite' => [
            'display' => 'favorite\'s site',
            'sub' => [
                'laravel' => [
                    'display' => 'Laravel',
                    'url' => 'https://laravel.com'
                ],
                'stackoverflow' => [
                    'display' => 'Stackoverflow',
                    'url' => 'http://stackoverflow.com'
                ]
            ]
        ]
    ]
];