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

$headNavList = array_filter($allNavItems, function ($item) use ($isLoggedIn, $role) {
    if (!empty($item['guestOnly']) && $isLoggedIn) return false;
    if (!empty($item['authOnly']) && !$isLoggedIn) return false;
    if (isset($item['role']) && $item['role'] !== $role) return false;
    if (isset($item['hideFor']) && $item['hideFor'] === $role) return false;
    return true;
});

// 4. Render Layout
function renderMainLayout(callable $content, array $customJsCss = []): void
{
    global $headNavList, $user;

    head($customJsCss['css'] ?? []);
    navHeader($headNavList, $user);

    // --- Inline CSS for loader ---
    echo <<<STYLE
    <style>
      #loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #0d0d0d;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
      }
      .blood-spinner {
        position: relative;
        width: 60px;
        height: 100px;
      }
      .drip {
        width: 20px;
        height: 20px;
        background: #8b0000;
        border-radius: 50%;
        position: absolute;
        left: 20px;
        top: 0;
        animation: drip 2.5s infinite ease-in;
      }
      .delay1 { animation-delay: 0.5s; }
      .delay2 { animation-delay: 1s; }
      .blood-pool {
        position: absolute;
        bottom: 0;
        left: 10px;
        width: 40px;
        height: 20px;
        background: #8b0000;
        border-radius: 50%;
        opacity: 0.8;
      }
      @keyframes drip {
        0% { top: 0; opacity: 1; transform: scaleY(1); }
        50% { top: 60px; opacity: 0.7; transform: scaleY(1.5); }
        100% { top: 100px; opacity: 0; transform: scaleY(2); }
      }
    </style>
    STYLE;

    // --- Loader HTML ---
    echo <<<HTML
    <div id="loader">
      <div class="blood-spinner">
        <div class="drip"></div>
        <div class="drip delay1"></div>
        <div class="drip delay2"></div>
        <div class="blood-pool"></div>
      </div>
    </div>
    <div id="content" style="display: none;">
    HTML;

    // Page content
    $content();

    // Close #content wrapper
    echo '</div>';

    // JS for loader delay
    echo <<<SCRIPT
    <script>
      window.addEventListener("load", function () {
        setTimeout(() => {
          document.getElementById("loader").style.display = "none";
          document.getElementById("content").style.display = "block";
        }, 2000); // 5 seconds
      });
    </script>
    SCRIPT;

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
