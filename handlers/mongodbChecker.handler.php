<?php

require_once BASE_PATH . '/bootstrap.php';
require_once UTILS_PATH . '/envSetter.util.php';

try {
    $mongo = new MongoDB\Driver\Manager($typeConfig['mongoUri']);

    $command = new MongoDB\Driver\Command(["ping" => 1]);
    $mongo->executeCommand($typeConfig['mongoDB'], $command);

    echo "✅ Connected to MongoDB successfully.  <br>";
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "❌ MongoDB connection failed: " . $e->getMessage() . "  <br>";
}
