<?php
require_once VENDOR_PATH . 'autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH); // use BASE_PATH here
$dotenv->load();

$isDocker = file_exists('/.dockerenv');

return [
    'pg_host'    => $isDocker ? 'postgresql' : 'localhost',
    'pg_port'    => $isDocker ? '5432' : '5112',
    'pg_db'      => $_ENV['PG_DB'],
    'pg_user'    => $_ENV['PG_USER'],
    'pg_pass'    => $_ENV['PG_PASS'],
    'mongo_uri'  => $_ENV['MONGO_URI'],
    'mongo_db'   => $_ENV['MONGO_DB'],
];