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
        'title' => 'Categories'
    ],

    [
        'icon' => 'far fa-circle nav-icon',
        'route' => 'dashboard.products.index',
        'active' => 'dashboard.products.*',
        'title' => 'products'
    ],
];
