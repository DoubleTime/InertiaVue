<?php

return [

    /*
    |--------------------------------------------------------------------------
    | DEFINE MENU
    |--------------------------------------------------------------------------
    */

    'items' => [
        [
            'title' => 'Dashboard',
            'route' => 'dashboard'
        ],
        [
            'title' => 'Masterfile',
            'route' => '',
            'submenus' => [
                [
                    'title' => 'Users',
                    'route' => 'users.index'
                ],
                [
                    'title' => 'Profile',
                    'route' => '',
                    'submenus' => [
                        [
                            'title' => 'Edit Profile',
                            'route' => 'profile.edit'
                        ]
                    ]
                ],
            ]

        ]
    ]
];
