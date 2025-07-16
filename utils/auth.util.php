<?php
declare(strict_types=1);

include_once UTILS_PATH . "/envSetter.util.php";

class Auth
{
    public static function init(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function login(PDO $pdo, string $username, string $password): bool
    {
        try {
            // 🔧 Removed LEFT JOIN to public.images
            $stmt = $pdo->prepare("
                SELECT
                    user_id,
                    first_name,
                    last_name,
                    username,
                    password,
                    role
                FROM public.\"users\"
                WHERE username = :username
            ");
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            error_log('[Auth::login] PDOException: ' . $e->getMessage());
            return false;
        }

        if (!$user) {
            error_log("[Auth::login] No user found for username='{$username}'");
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            error_log("[Auth::login] Password mismatch for user_id={$user['id']}");
            return false;
        }

        session_regenerate_id(true);
       $_SESSION['user'] = [
    'id'         => $user['user_id'],  // now this key exists
    'first_name' => $user['first_name'],
    'last_name'  => $user['last_name'],
    'username'   => $user['username'],
    'role'       => $user['role'],
];

        error_log("[Auth::login] Login successful for user_id={$user['id']}");

        return true;
    }

    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
    }
}
