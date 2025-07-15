<?php
// BASE_PATH should point to the root of your project (typically /var/www/html in Docker)
define('BASE_PATH', realpath(__DIR__));
define('HANDLERS_PATH', realpath(BASE_PATH . '/handlers'));
define('UTILS_PATH', realpath(BASE_PATH . '/utils'));
define('DUMMIES_PATH', realpath(BASE_PATH . '/staticDatas/dummies'));
define('DATABASE_PATH', realpath(BASE_PATH . '/database'));
define('VENDOR_PATH', BASE_PATH . '/vendor');
define('TEMPLATES_PATH', realpath(BASE_PATH . '/components/templates'));
define('STATICDATAS_PATH', realpath(BASE_PATH . '/staticDatas'));
define('LAYOUTS_PATH', realpath(BASE_PATH . '/layouts'));


chdir(BASE_PATH);
    