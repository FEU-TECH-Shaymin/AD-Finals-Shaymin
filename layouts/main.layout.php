<?php
declare(strict_types=1);

// 1. Bootstrap, Autoload, Auth
require_once BASE_PATH . '/bootstrap.php';
require_once BASE_PATH . '/vendor/autoload.php';
require_once UTILS_PATH . '/auth.util.php';
require_once UTILS_PATH . "/envSetter.util.php";

Auth::init();

// 2. Load templates
require_once TEMPLATES_PATH . '/head.component.php';
require_once TEMPLATES_PATH . '/nav.component.php';
require_once TEMPLATES_PATH . '/foot.component.php';

// 3. Load nav data & filter
$allNavItems = require STATICDATAS_PATH . '/navPages.staticData.php';
$isLoggedIn = Auth::check();
$user = Auth::user();

$headNavList = array_filter($allNavItems, function ($item) use ($isLoggedIn, $user) {
    // Auth-only check
    if (!empty($item['authOnly']) && !$isLoggedIn) return false;

    // Guest-only check
    if (!empty($item['guestOnly']) && $isLoggedIn) return false;

    // Role check
    if (!empty($item['role'])) {
        if (!$isLoggedIn || !isset($user['role']) || $user['role'] !== $item['role']) {
            return false;
        }
    }

    return true;
});


// 4. Main layout function
function renderMainLayout(callable $content, array $customJsCss = []): void
{
    global $headNavList, $user;

    // Load the HTML <head> and include CSS
    head($customJsCss['css'] ?? []);

    // Render the navigation bar with filtered items
    navHeader($headNavList, $user);

    // Render the page content
    $content();

    // Load the <footer> and include JS
    footer($customJsCss['js'] ?? []);
}
