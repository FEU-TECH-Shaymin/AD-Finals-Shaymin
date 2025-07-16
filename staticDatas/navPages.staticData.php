<?php
return [
    // Public Pages
    ['label' => 'Home', 'url' => '/index.php'],
    ['label' => 'About', 'url' => '/pages/about/index.php'],
    ['label' => 'Products', 'url' => '/pages/products/index.php', 'hideFor' => 'admin'],
    ['label' => 'Contact', 'url' => '/pages/contact/index.php'],

    // Guest Only
    ['label' => 'Login', 'url' => '/pages/login/index.php', 'guestOnly' => true],
    ['label' => 'Sign Up', 'url' => '/pages/signup/index.php', 'guestOnly' => true],

    // Admin Only
    ['label' => 'Product Management', 'url' => '/pages/admin-products/index.php', 'authOnly' => true, 'role' => 'admin'],
    ['label' => 'Order Management', 'url' => '/pages/admin-orders/index.php', 'authOnly' => true, 'role' => 'admin'],
    ['label' => 'Admin Dashboard', 'url' => '/pages/admin/index.php', 'authOnly' => true, 'role' => 'admin'],

    // User Only
    ['label' => 'Order', 'url' => '/pages/orders/index.php', 'hideFor' => 'admin'],
    ['label' => 'User Dashboard', 'url' => '/pages/user/index.php', 'hideFor' => 'admin'],

    // Shared by all logged-in roles
    ['label' => 'Logout', 'url' => '/handlers/auth.handler.php?action=logout', 'authOnly' => true],
];
