<?php
// admin/actions/mark_inquiry_read.php
require_once '../../includes/config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']); exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = sanitize($_POST['id']);
    $status = sanitize($_POST['status'] ?? 'Read'); // Default is 'Read'
    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role'];

    // Check if user owns the project or is super_admin
    $check_q = mysqli_query($conn, "SELECT p.user_id FROM inquiries i 
                                   LEFT JOIN projects p ON i.project_id = p.id 
                                   WHERE i.id = '$id'");
    $row = mysqli_fetch_assoc($check_q);

    if ($role == 'super_admin' || $row['user_id'] == $user_id) {
        $sql = "UPDATE inquiries SET status = '$status' WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'DB Error']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    }
}
?>
