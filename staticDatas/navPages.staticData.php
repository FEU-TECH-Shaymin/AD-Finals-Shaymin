<?php
return [
    ["label" => "Home", "url" => "/index.php", "for" => "user"],    
    ["label" => "About", "url" => "/pages/about/index.php", "for" => "user"],
    ["label" => "Products", "url" => "/pages/products/index.php", "for" => "user"],
    ["label" => "Contact", "url" => "/pages/contact/index.php", "for" => "user"],
    ["label" => "Login", "url" => "/pages/login/index.php", "for" => "guest"], 
    ["label" => "Logout", "url" => "/handlers/auth.handler.php?action=logout", "for" => "auth"] 
];
