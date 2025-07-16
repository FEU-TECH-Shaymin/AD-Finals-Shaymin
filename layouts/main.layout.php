<?php
declare(strict_types=1);

// 1. Bootstrap & Auth Setup
require_once BASE_PATH . '/bootstrap.php';
require_once BASE_PATH . '/vendor/autoload.php';
require_once UTILS_PATH . '/auth.util.php';
require_once UTILS_PATH . '/envSetter.util.php';

Auth::init();

// 2. Templates
require_once TEMPLATES_PATH . '/head.component.php';
require_once TEMPLATES_PATH . '/nav.component.php';
require_once TEMPLATES_PATH . '/foot.component.php';

// 3. Load and Filter Navigation
$allNavItems = require STATICDATAS_PATH . '/navPages.staticData.php';
$isLoggedIn = Auth::check();
$user = Auth::user();
$role = trim($user['role'] ?? '');

// Filter navigation items
$headNavList = array_filter($allNavItems, function ($item) use ($isLoggedIn, $role) {
    // Hide if guestOnly but user is logged in
    if (!empty($item['guestOnly']) && $isLoggedIn) {
        return false;
    }

    // Hide if authOnly but user is not logged in
    if (!empty($item['authOnly']) && !$isLoggedIn) {
        return false;
    }

    // Hide if specific role required and user doesn't match
    if (isset($item['role']) && $item['role'] !== $role) {
        return false;
    }

    // Hide if explicitly blocked for this role
    if (isset($item['hideFor']) && $item['hideFor'] === $role) {
        return false;
    }

    return true;
});

// 4. Render Layout
function renderMainLayout(callable $content, array $customJsCss = []): void
{
    global $headNavList, $user;

    head($customJsCss['css'] ?? []);
    navHeader($headNavList, $user);  // navHeader expects nav list and user info
    $content();
    footer($customJsCss['js'] ?? []);
}

// 5. Auth Control Helpers
function requireAuth(): void {
    if (!Auth::check()) {
        header('Location: /pages/login/index.php?error=unauthorized');
        exit;
    }
}

function requireGuest(): void {
    if (Auth::check()) {
        header('Location: /index.php');
        exit;
    }
}

function requireRole(string $requiredRole): void {
    $user = Auth::user();
    $role = trim($user['role'] ?? '');
    if (!Auth::check() || $role !== $requiredRole) {
        header('Location: /index.php?error=forbidden');
        exit;
    }
}

function requireNotAdmin(): void {
    $user = Auth::user();
    $role = trim($user['role'] ?? '');
    if (Auth::check() && $role === 'admin') {
        header('Location: /pages/admin/index.php?error=not_allowed');
        exit;
    }
}
