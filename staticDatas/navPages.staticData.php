<?php
return [
    ['label' => 'Home', 'url' => '/index.php'],
    ['label' => 'About', 'url' => '/pages/about/index.php'],
    ['label' => 'Products', 'url' => '/pages/products/index.php'],
    ['label' => 'Contact', 'url' => '/pages/contact/index.php'],

    // Guest only
    ['label' => 'Login', 'url' => '/pages/login/index.php', 'guestOnly' => true],
    ['label' => 'Signup', 'url' => '/pages/signup/index.php', 'guestOnly' => true],

    // Authenticated only
    ['label' => 'User Dashboard', 'url' => '/pages/user/index.php', 'authOnly' => true, 'role' => 'user'],
    ['label' => 'Product', 'url' => '/pages/products/index.php', 'authOnly' => true, 'role' => 'user'],
     ['label' => 'Order', 'url' => '/pages/user/index.php', 'authOnly' => true, 'role' => 'user'],


    ['label' => 'Admin Dashboard', 'url' => '/pages/admin/index.php', 'authOnly' => true, 'role' => 'admin'],
    ['label' => 'Product', 'url' => '/pages/admin-products/index.php', 'authOnly' => true, 'role' => 'admin'],
    ['label' => 'Orders', 'url' => '/pages/admin-orders/index.php', 'authOnly' => true, 'role' => 'admin'],


    ['label' => 'Logout', 'url' => '/handlers/auth.handler.php?action=logout', 'authOnly' => true],
];
