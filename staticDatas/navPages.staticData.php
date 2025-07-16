<?php
return [
    // Public
    ['label' => 'Home', 'url' => '/index.php'],
    ['label' => 'About', 'url' => '/pages/about/index.php'],
    ['label' => 'Products', 'url' => '/pages/products/index.php'],
  ['label' => 'Login', 'url' => '/pages/login/index.php', 'guestOnly' => true],
    ['label' => 'Sign-up', 'url' => '/pages/signup/index.php', 'guestOnly' => true],



    // User-only
    ['label' => 'Order', 'url' => '/pages/orders/index.php', 'authOnly' => true, 'role' => 'user'],
    ['label' => 'User Dashboard', 'url' => '/pages/user/index.php', 'authOnly' => true, 'role' => 'user'],

    // Admin-only
    ['label' => 'Admin Dashboard', 'url' => '/pages/admin/index.php', 'authOnly' => true, 'role' => 'admin'],
    ['label' => 'Manage Products', 'url' => '/pages/admin/products.php', 'authOnly' => true, 'role' => 'admin'],
    
];
