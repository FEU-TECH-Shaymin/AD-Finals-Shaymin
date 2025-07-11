require_once __DIR__ . '/../utils/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);   // Method Not Allowed
    exit;
}
