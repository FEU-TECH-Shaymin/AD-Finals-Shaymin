<?php

require_once BASE_PATH . '/bootstrap.php';
require_once BASE_PATH . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

$typeConfig = [
    // PostgreSQL
    'pgHost'     => $_ENV['PG_HOST'],
    'pgPort'     => $_ENV['PG_PORT'],
    'pgDb'       => $_ENV['PG_DB'],
    'pgUser'     => $_ENV['PG_USER'],
    'pgPassword' => $_ENV['PG_PASS'],

    // MongoDB
    'mongoUri'   => $_ENV['MONGO_URI'],
    'mongoDB'    => $_ENV['MONGO_DB'],
];