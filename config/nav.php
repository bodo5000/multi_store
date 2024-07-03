<?php

return [
    [
        'icon' => 'nav-icons fas fa-tachometer-alt',
        'route' => 'dashboard.dashboard',
        'active' => 'dashboard.dashboard',
        'title' => 'Dashboard'
    ],

    [
        'icon' => 'far fa-circle nav-icon',
        'route' => 'dashboard.categories.index',
        'active' => 'dashboard.categories.*',
        'title' => 'Categories',
        'ability' => 'categories.view'
    ],

    [
        'icon' => 'far fa-circle nav-icon',
        'route' => 'dashboard.products.index',
        'active' => 'dashboard.products.*',
        'title' => 'products',
        'ability' => 'products.view'
    ],

    [
        'icon' => 'far fa-circle nav-icon',
        'route' => 'dashboard.roles.index',
        'active' => 'dashboard.roles.*',
        'title' => 'roles',
    ],

    // [
    //     'icon' => 'far fa-circle nav-icon',
    //     'route' => 'dashboard.orders.index',
    //     'active' => 'dashboard.orders.*',
    //     'title' => 'orders',
    //     'ability' => 'orders.view'
    // ],
];
