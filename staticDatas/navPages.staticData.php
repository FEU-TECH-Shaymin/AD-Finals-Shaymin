<?php
return [
    ["label" => "Home", "url" => "/index.php", "for" => "member"],     // ✅ visible to logged-in "Member"
    ["label" => "About", "url" => "/pages/about/index.php", "for" => "member"],
    ["label" => "Products", "url" => "/pages/products/index.php", "for" => "member"],
    ["label" => "Contact", "url" => "/pages/contact/index.php", "for" => "member"],
    ["label" => "Login", "url" => "/pages/login/index.php", "for" => "guest"], // ✅ visible only if NOT logged in
    ["label" => "Logout", "url" => "/handlers/auth.handler.php?action=logout", "for" => "auth"] // ✅ visible to ANY logged-in user
];
