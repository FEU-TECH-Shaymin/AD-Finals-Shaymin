<?php
require_once VENDOR_PATH . '/autoload.php';

// Load .env variables from BASE_PATH (your project root)
$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

// Check if running inside Docker
$isDocker = file_exists('/.dockerenv');

return [
    // PostgreSQL
    'pgHost'     => $isDocker ? 'shaymin-postgresql' : ($_ENV['PG_HOST'] ?? 'localhost'),
    'pgPort'     => $isDocker ? '5432' : ($_ENV['PG_PORT'] ?? '5112'),
    'pgDb'       => $_ENV['PG_DB']   ?? 'shayminpostgredb',
    'pgUser'     => $_ENV['PG_USER'] ?? 'shaymin',
    'pgPassword' => $_ENV['PG_PASS'] ?? 'Password123_',

    // MongoDB (still using .env for URI)
    'mongo_uri'  => $_ENV['MONGO_URI'],
    'mongo_db'   => $_ENV['MONGO_DB'] ?? 'shayminmongodb',
];
