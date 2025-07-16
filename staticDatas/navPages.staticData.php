<?php
return [
    ['label' => 'Home', 'url' => '/index.php'],
    ['label' => 'About', 'url' => '/pages/about/index.php', 'authOnly' => true],
     ['label' => 'Products', 'url' => '/pages/about/index.php', 'authOnly' => true],
     ['label' => 'Contact', 'url' => '/pages/contact/index.php', 'authOnly' => true],
    ['label' => 'Login', 'url' => '/pages/login/index.php', 'guestOnly' => true],
    ['label' => 'Signup', 'url' => '/pages/signup/index.php', 'guestOnly' => true],
    ['label' => 'Logout', 'url' => '/handlers/auth.handler.php', 'authOnly' => true],
    
];
