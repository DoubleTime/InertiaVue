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
            'submenus' => [
                [
                    'title' => 'Users',
                    'route' => 'users.index'
                ],
                [
                    'title' => 'Profile',
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
