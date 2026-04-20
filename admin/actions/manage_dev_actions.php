<?php
// admin/actions/manage_dev_actions.php
require_once '../../includes/config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'super_admin') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']); exit;
}

$action = $_POST['action'] ?? '';
$id = sanitize($_POST['id'] ?? '');

if ($action == 'delete') {
    $sql = "DELETE FROM users WHERE id = '$id' AND role = 'developer'";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Developer removed.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'DB Error']);
    }
} 

elseif ($action == 'reset_pw') {
    $new_pw = sanitize($_POST['new_password']);
    $hashed = password_hash($new_pw, PASSWORD_DEFAULT);
    
    $sql = "UPDATE users SET password = '$hashed' WHERE id = '$id' AND role = 'developer'";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Password reset successfully to: ' . $new_pw]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'DB Error']);
    }
}
?>
