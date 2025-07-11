require_once __DIR__ . '/../utils/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);   // Method Not Allowed
    exit;
}

$first  = $_POST['first_name']  ?? '';
$middle = $_POST['middle_name'] ?? null;
$last   = $_POST['last_name']   ?? '';
$user   = $_POST['username']    ?? '';
$pass   = $_POST['password']    ?? '';

if (!$first || !$last || !$user || !$pass) {
    exit('Missing required fields.');
}