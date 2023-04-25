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
            'title' => 'Profile',
            'route' => '',
            'submenus' => [
                [
                    'title' => 'Profile Edit',
                    'route' => 'profile.edit'
                ],
                [
                    'title' => 'Users',
                    'route' => '',
                    'submenus' => [
                        [
                            'title' => 'Index',
                            'route' => 'users.index'
                        ],
                        [
                            'title' => 'Create',
                            'route' => 'users.create'
                        ],
                    ]
                ],
            ]

        ]
    ]
];
