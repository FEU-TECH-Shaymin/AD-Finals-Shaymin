<?php

declare(strict_types=1);

// 1) Autoload
require 'vendor/autoload.php';

// 2) Bootstrap
require 'bootstrap.php';

// 3) Load environment
$typeConfig = require_once UTILS_PATH . '/envSetter.util.php';

