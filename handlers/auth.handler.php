<?php
declare(strict_types=1);
session_start();

// Bootstrap + DB config
require_once '../bootstrap.php';
require_once UTILS_PATH . 'envSetter.util.php';

$pgConfig = [
    'host' => $typeConfig['pg_host'],
    'port' => $typeConfig['pg_port'],
    'db'   => $typeConfig['pg_db'],
    'user' => $typeConfig['pg_user'],
    'pass' => $typeConfig['pg_pass'],
];

