<?php
// Set these values to match your local XAMPP MySQL setup.
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'student_record_system');
define('DB_USER', 'root');
define('DB_PASS', '');
define('MAX_UPLOAD_BYTES', 10 * 1024 * 1024); // 10 MB
// Change this to a private code shared only with authorized teachers before use.
define('TEACHER_SIGNUP_CODE', '1234');

if (session_status() !== PHP_SESSION_ACTIVE) {
    ini_set('session.use_strict_mode', '1');
    session_start();
}

function db(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
    return $pdo;
}
function h($value): string { return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function check_csrf(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sent = $_POST['csrf'] ?? '';
        if (!is_string($sent) || !hash_equals(csrf_token(), $sent)) {
            http_response_code(419); exit('Your session expired. Please go back, refresh, and try again.');
        }
    }
}
function current_user(): ?array { return $_SESSION['user'] ?? null; }
function require_login(): array {
    $user = current_user();
    if (!$user) { header('Location: index.php'); exit; }
    return $user;
}
function require_role(string $role): array {
    $user = require_login();
    if ($user['role'] !== $role) { http_response_code(403); exit('You do not have permission to access this page.'); }
    return $user;
}
function flash(string $message, string $type='success'): void { $_SESSION['flash'] = ['message'=>$message, 'type'=>$type]; }
function take_flash(): ?array { $f = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $f; }
