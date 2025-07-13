<?php
// BASE_PATH should point to the root of your project (typically /var/www/html in Docker)
define('BASE_PATH', realpath(__DIR__));

// Define other relevant paths relative to the base
define('HANDLERS_PATH', BASE_PATH . '/handlers');
define('UTILS_PATH', BASE_PATH . '/utils');
define('DUMMIES_PATH', BASE_PATH . '/staticDatas/dummies');
define('DATABASE_PATH', BASE_PATH . '/database');
define('VENDOR_PATH', BASE_PATH . '/vendor');
define('LAYOUTS_PATH', BASE_PATH . '/layouts');


// Change the current directory to BASE_PATH
chdir(BASE_PATH);
