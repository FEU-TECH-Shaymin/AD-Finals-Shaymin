<?php
require_once VENDOR_PATH . 'autoload.php';

// Load .env variables from BASE_PATH (your project root)
$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

// Check if running inside Docker
$isDocker = file_exists('/.dockerenv');

// Return environment config
return [
    'pg_host'   => $_ENV['PG_HOST']   ?? ($isDocker ? 'shaymin-postgresql' : 'localhost'),
    'pg_port'   => $_ENV['PG_PORT']   ?? ($isDocker ? '5432' : '5112'),
    'pg_db'     => $_ENV['PG_DB']     ?? 'shayminpostgredb',
    'pg_user'   => $_ENV['PG_USER']   ?? 'shaymin',
    'pg_pass'   => $_ENV['PG_PASS']   ?? 'Password123_',
    'mongo_uri' => $_ENV['MONGO_URI'] ?? ($isDocker
         ? 'mongodb://shaymin:Password123_@shaymin-mongodb:27017'
                :          'mongodb://shaymin:Password123_@localhost:27111'),
    'mongo_db'  => $_ENV['MONGO_DB']  ?? 'default_mongo_db',
];