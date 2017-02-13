<?php

return [
    'admin' => [
        'user' => [
            'update' => [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'nullable|min:6',
            ],
            'store' => [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'min:6',
            ],
        ],
        'role' => [
            'update' => [
                'name' => 'required|max:255|unique:role,name',
                'display_name' => 'required|max:255',
            ],
            'store' => [
                'name' => 'required|max:255|unique:role,name',
                'display_name' => 'required|max:255',
            ],
        ],
    ],
];