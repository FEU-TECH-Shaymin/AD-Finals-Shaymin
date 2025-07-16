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
    // Guest-only: only if not logged in
    if (isset($item['guestOnly']) && $item['guestOnly'] === true && $isLoggedIn) {
        return false;
    }

    // Auth-only: only if logged in
    if (isset($item['authOnly']) && $item['authOnly'] === true && !$isLoggedIn) {
        return false;
    }

    // Role-based: only match if role exactly matches
    if (isset($item['role'])) {
        if (!$isLoggedIn || !isset($user['role']) || $item['role'] !== $user['role']) {
            return false;
        }
    }

    // Hide for specific role
    if (isset($item['hideFor']) && isset($user['role']) && $item['hideFor'] === $user['role']) {
        return false;
    }

    return true;
});

// 4. Main layout function
function renderMainLayout(callable $content, array $customJsCss = []): void
{
    global $headNavList, $user;

    head($customJsCss['css'] ?? []);
    navHeader($headNavList, $user);
    $content();
    footer($customJsCss['js'] ?? []);
}

// 5. Access control functions

/**
 * Only allow logged-in users.
 */
function requireAuth(): void {
    if (!Auth::check()) {
        header('Location: /pages/login/index.php?error=unauthorized');
        exit;
    }
}

/**
 * Only allow guests (not logged in).
 */
function requireGuest(): void {
    if (Auth::check()) {
        header('Location: /index.php');
        exit;
    }
}

/**
 * Only allow users with a specific role (e.g., 'admin', 'user').
 */
function requireRole(string $role): void {
    $user = Auth::user();
    if (!Auth::check() || !isset($user['role']) || $user['role'] !== $role) {
        header('Location: /index.php?error=forbidden');
        exit;
    }
}

/**
 * Allow guests and users, but block admins.
 */
function requireNotAdmin(): void {
    $user = Auth::user();
    if (Auth::check() && ($user['role'] ?? '') === 'admin') {
        header('Location: /pages/admin/index.php?error=not_allowed');
        exit;
    }
}
