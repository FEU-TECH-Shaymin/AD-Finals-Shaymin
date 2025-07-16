<?php
return [
    ['label' => 'Home', 'url' => '/index.php'],
    ['label' => 'About', 'url' => '/pages/about/index.php'],
    ['label' => 'Products', 'url' => '/pages/products/index.php', 'hideFor' => 'admin'],
    ['label' => 'Contact', 'url' => '/pages/contact/index.php'],

    ['label' => 'Login', 'url' => '/pages/login/index.php', 'guestOnly' => true],
    ['label' => 'Signup', 'url' => '/pages/signup/index.php', 'guestOnly' => true],

    // User only
    ['label' => 'Order', 'url' => '/pages/user/index.php', 'authOnly' => true, 'role' => 'user'],
    ['label' => 'User Dashboard', 'url' => '/pages/user/index.php', 'authOnly' => true, 'role' => 'user'],

    // Admin only
    ['label' => 'Product Management', 'url' => '/pages/admin-products/index.php', 'authOnly' => true, 'role' => 'admin'],
    ['label' => 'Order Management', 'url' => '/pages/admin-orders/index.php', 'authOnly' => true, 'role' => 'admin'],
    ['label' => 'Admin Dashboard', 'url' => '/pages/admin/index.php', 'authOnly' => true, 'role' => 'admin'],
    ['label' => 'Logout', 'url' => '/handlers/auth.handler.php?action=logout', 'authOnly' => true],
];
