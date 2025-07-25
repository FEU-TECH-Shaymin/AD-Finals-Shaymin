<?php

require_once BASE_PATH . '/bootstrap.php'; // defines paths
$typeConfig = require UTILS_PATH . '/envSetter.util.php';

$host     = $typeConfig['pgHost'];
$port     = $typeConfig['pgPort'];
$username = $typeConfig['pgUser'];
$password = $typeConfig['pgPassword'];
$dbname   = $typeConfig['pgDb'];

$conn_string = "host=$host port=$port dbname=$dbname user=$username password=$password";

$dbconn = pg_connect($conn_string);

if (!$dbconn) {
    echo "❌ Connection Failed: " . pg_last_error($dbconn) . "<br>";
    exit();
} else {
    echo "✔️ PostgreSQL Connection successful!<br>";
    pg_close($dbconn);
}
