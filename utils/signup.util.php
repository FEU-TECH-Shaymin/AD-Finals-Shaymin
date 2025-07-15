<?php
declare(strict_types=1);

include_once UTILS_PATH . '/envSetter.util.php';

class Signup
{
    /**
     * Validate the raw input; returns an array of error messages (empty if valid)
     *
     * @param array $data  Expecting keys: first_name, middle_name, last_name, username, password
     * @return string[]    List of validation errors
     */
    public static function validate(array $data): array
    {
        $errors = [];

        // Trim all inputs once
        $first_name = trim($data['first_name'] ?? '');
        $last_name = trim($data['last_name'] ?? '');
        $username = trim($data['username'] ?? '');
        $password = $data['password'] ?? '';

        // 1) Required fields
        if ($first_name === '') {
            $errors[] = 'First name is required.';
        }
        if ($last_name === '') {
            $errors[] = 'Last name is required.';
        }
        if ($username === '') {
            $errors[] = 'Username is required.';
        }

        // 2) Password policy
        $pwLen = strlen($password);
        if (
            $pwLen < 8
            || !preg_match('/[A-Z]/', $password)
            || !preg_match('/[a-z]/', $password)
            || !preg_match('/\d/', $password)
            || !preg_match('/\W/', $password)
        ) {
            $errors[] = 'Password must be at least 8 characters and include uppercase, lowercase, number, and special character.';
        }

        return $errors;
    }

    /**
     * Create the user in the database. Role is fixed as 'Member'.
     *
     * @param PDO   $pdo
     * @param array $data  Same keys as validate()
     * @return void
     * @throws PDOException on SQL errors
     */
    public static function create(PDO $pdo, array $data): void
    {
        $stmt = $pdo->prepare("
            INSERT INTO public.\"users\"
              (first_name, middle_name, last_name, username, password, role)
            VALUES
              (:first, :middle, :last, :username, :password, 'Member')
        ");

        $hashed = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt->execute([
            ':first' => trim($data['first_name']),
            ':middle' => trim($data['middle_name'] ?? '') !== '' ? trim($data['middle_name']) : null,
            ':last' => trim($data['last_name']),
            ':username' => trim($data['username']),
            ':password' => $hashed,
        ]);
    }
}
