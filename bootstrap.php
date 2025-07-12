<?php
define('BASE_PATH', dirname(__FILE__)); // more reliable
define('HANDLERS_PATH', BASE_PATH . '/handlers');
define('UTILS_PATH', BASE_PATH . '/utils');
define('DUMMIES_PATH', BASE_PATH . '/staticDatas/dummies');
define('DATABASE_PATH', BASE_PATH . '/database');
define('VENDOR_PATH', BASE_PATH . '/vendor');

chdir(BASE_PATH);
