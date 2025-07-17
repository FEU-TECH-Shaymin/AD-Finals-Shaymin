<?php
return [
    // User-only
    ['label' => 'Dashboard', 'url' => '/pages/user/index.php', 'authOnly' => true, 'role' => 'user'],
    ['label' => 'Order', 'url' => '/pages/orders/index.php', 'authOnly' => true, 'role' => 'user'],
    

    // Admin-only
    ['label' => 'Dashboard', 'url' => '/pages/admin/index.php', 'authOnly' => true, 'role' => 'admin'],
    ['label' => 'Manage Users', 'url' => '/pages/admin-users/index.php', 'authOnly' => true, 'role' => 'admin'],
    ['label' => 'Manage Orders', 'url' => '/pages/admin-orders/index.php', 'authOnly' => true, 'role' => 'admin'],

    // Public
    ['label' => 'Home', 'url' => '/index.php', 'guestOnly' => true],
    ['label' => 'About', 'url' => '/pages/about/index.php'],
    ['label' => 'Products', 'url' => '/pages/products/index.php'],
    ['label' => 'Contact', 'url' => '/pages/contact/index.php'],
    ['label' => 'Login', 'url' => '/pages/login/index.php', 'guestOnly' => true],
    ['label' => 'Sign-up', 'url' => '/pages/signup/index.php', 'guestOnly' => true],
];
