<?php
declare(strict_types=1);

require_once BASE_PATH . '/bootstrap.php';
require_once VENDOR_PATH . '/autoload.php';
require_once UTILS_PATH . '/envSetter.util.php';
require_once UTILS_PATH . '/auth.util.php';
require_once UTILS_PATH . '/signup.util.php';

Auth::init();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and collect inputs
    $formData = [
        'first_name' => $_POST['first_name'] ?? '',
        'middle_name' => $_POST['middle_name'] ?? '',
        'last_name' => $_POST['last_name'] ?? '',
        'username' => $_POST['username'] ?? '',
        'password' => $_POST['password'] ?? '',
    ];

    // 1. Validate input
    $errors = Signup::validate($formData);
    if (!empty($errors)) {
        header('Location: /pages/signup/index.php?error=' . urlencode(implode(' ', $errors)));
        exit;
    }

    try {
        $pdo = Database::connect();

        // 2. Check if username already exists
        $stmt = $pdo->prepare("SELECT id FROM public.\"users\" WHERE username = :username");
        $stmt->execute([':username' => trim($formData['username'])]);
        if ($stmt->fetch()) {
            header('Location: /pages/signup/index.php?error=' . urlencode('Username already exists.'));
            exit;
        }

        // 3. Create the user with fixed role = 'Member'
        Signup::create($pdo, $formData);

        // 4. Fetch user data
        $stmt = $pdo->prepare("SELECT id, first_name, last_name, username, role FROM public.\"users\" WHERE username = :username");
        $stmt->execute([':username' => trim($formData['username'])]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['user'] = $user;

            // 5. Redirect to user dashboard
            header('Location: /pages/user/index.php');
            exit;
        } else {
            header('Location: /pages/signup/index.php?error=' . urlencode('Signup failed. Please try again.'));
            exit;
        }

    } catch (PDOException $e) {
        error_log("Signup failed: " . $e->getMessage());
        header('Location: /pages/signup/index.php?error=' . urlencode('A server error occurred.'));
        exit;
    }
} else {
    header('Location: /pages/signup/index.php?error=' . urlencode('Invalid request.'));
    exit;
}
