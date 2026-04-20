<?php
// admin/actions/add_developer.php
require_once '../../includes/config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'super_admin') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']); exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = sanitize($_POST['full_name']);
    $username = sanitize($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (full_name, username, password, role) VALUES ('$full_name', '$username', '$password', 'developer')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Username already exists.']);
    }
}
?>
