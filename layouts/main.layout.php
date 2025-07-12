<?php
declare(strict_types=1);

// 1. Bootstrap, Autoload, Auth
require_once BASE_PATH . '/bootstrap.php';
require_once BASE_PATH . '/vendor/autoload.php';
require_once UTILS_PATH . '/auth.util.php';
Auth::init();

// 2. Load templates
require_once TEMPLATES_PATH . '/head.component.php';
require_once TEMPLATES_PATH . '/nav.component.php';
require_once TEMPLATES_PATH . '/foot.component.php';
require_once UTILS_PATH . "/envSetter.util.php";
