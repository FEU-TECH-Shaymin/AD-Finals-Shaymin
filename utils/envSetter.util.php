<?php
require_once VENDOR_PATH . '/autoload.php';

// Load .env variables from BASE_PATH (your project root)
$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

// Check if running inside Docker
$isDocker = file_exists('/.dockerenv');

return [
    'pgHost'     => $_ENV['PG_HOST'] ?? ($isDocker ? 'shaymin-postgresql' : 'localhost'),
    'pgPort'     => $_ENV['PG_PORT'] ?? ($isDocker ? '5432' : '5112'),
    'pgDb'       => $_ENV['PG_DB']   ?? 'shayminpostgredb',
    'pgUser'     => $_ENV['PG_USER'] ?? 'shaymin',
    'pgPassword' => $_ENV['PG_PASS'] ?? 'Password123_',

    'mongo_uri'  => $_ENV['MONGO_URI'],
    'mongo_db'   => $_ENV['MONGO_DB'] ?? 'shayminmongodb',
];
