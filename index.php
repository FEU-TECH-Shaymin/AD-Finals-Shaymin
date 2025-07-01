<?php
define('HANDLERS_PATH', __DIR__ . '/handlers/');

echo "<h2>Database Connection Check</h2>";
include_once HANDLERS_PATH . "mongodbChecker.handler.php";
include_once HANDLERS_PATH . "postgreChecker.handler.php";
?>
