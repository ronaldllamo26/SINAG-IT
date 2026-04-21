<?php
// includes/config.php
// Security: Session Hardening
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    ini_set('session.cookie_secure', 1);
}

session_start();
session_regenerate_id(true); // Prevent session fixation

// Detection for localhost or InfinityFree
$is_local = (php_sapi_name() == 'cli' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1');

if ($is_local) {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'sinag');
} else {
    // InfinityFree Settings
    define('DB_HOST', 'sqlxxx.epizy.com');
    define('DB_USER', 'epiz_xxxxxx');
    define('DB_PASS', 'your_password');
    define('DB_NAME', 'epiz_xxxxxx_sinag');
}

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Security: Helper for escaping input
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags($data)));
}

// Global Site Settings
define('SITE_EMAIL', 'sinagit26@gmail.com');
?>
