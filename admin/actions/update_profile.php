<?php
// admin/actions/update_profile.php
require_once '../../includes/config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $full_name = sanitize($_POST['full_name']);
    $email = sanitize($_POST['email']);
    $new_password = $_POST['new_password'];

    if (empty($full_name) || empty($email)) {
        echo json_encode(['status' => 'error', 'message' => 'Name and Email are required.']);
        exit();
    }

    $sql = "UPDATE users SET full_name = '$full_name', email = '$email'";
    
    if (!empty($new_password)) {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $sql .= ", password = '$hashed'";
    }
    
    $sql .= " WHERE id = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Profile updated!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'DB Error: ' . mysqli_error($conn)]);
    }
}
?>
