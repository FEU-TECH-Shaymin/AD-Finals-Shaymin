<?php
define('BASE_PATH', realpath(__DIR__));
define('HANDLERS_PATH', realpath(BASE_PATH . '/handlers'));
define('UTILS_PATH', realpath(BASE_PATH . '/utils'));
define('DUMMIES_PATH', realpath(BASE_PATH . '/staticDatas/dummies'));
define('DATABASE_PATH', realpath(BASE_PATH . '/database'));
define('TEMPLATES_PATH', realpath(BASE_PATH . '/components/templates'));


chdir(BASE_PATH);