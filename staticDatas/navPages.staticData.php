<?php
return [
    // Public nav (guest only)
    ['label' => 'Home', 'url' => '/index.php'],
    ['label' => 'About', 'url' => '/pages/about/index.php'],
    ['label' => 'Products', 'url' => '/pages/products/index.php' , 'authOnly' => true, 'role' => 'user'],
    ['label' => 'Contact', 'url' => '/pages/contact/index.php' , 'authOnly' => true, 'role' => 'user'],
    ['label' => 'Login', 'url' => '/pages/login/index.php'],
    ['label' => 'Signup', 'url' => '/pages/signup/index.php'],
    ['label' => 'Order', 'url' => '/pages/user/index.php', 'authOnly' => true, 'role' => 'user'],
    ['label' => 'User Dashboard', 'url' => '/pages/user/index.php', 'authOnly' => true, 'role' => 'user'],

    // Admin nav (logged-in admins only)
    ['label' => 'Products', 'url' => '/pages/products/index.php', 'authOnly' => true, 'role' => 'admin'],
    ['label' => 'Contact', 'url' => '/pages/contact/index.php', 'authOnly' => true, 'role' => 'admin'],
    ['label' => 'Product Management', 'url' => '/pages/admin-products/index.php', 'authOnly' => true, 'role' => 'admin'],
    ['label' => 'Order Management', 'url' => '/pages/admin-orders/index.php', 'authOnly' => true, 'role' => 'admin'],
    ['label' => 'Admin Dashboard', 'url' => '/pages/admin/index.php', 'authOnly' => true, 'role' => 'admin'],

    // Shared for all logged-in users
    ['label' => 'Logout', 'url' => '/handlers/auth.handler.php?action=logout', 'authOnly' => true],
];
