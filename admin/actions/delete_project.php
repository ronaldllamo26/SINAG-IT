<?php
// admin/actions/delete_project.php
require_once '../../includes/config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']); exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = sanitize($_POST['id']);
    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role'];

    // Check if user owns the project or is superadmin
    $check = mysqli_query($conn, "SELECT user_id FROM projects WHERE id = '$id'");
    $project = mysqli_fetch_assoc($check);

    if ($project['user_id'] == $user_id || $role == 'super_admin') {
        if (mysqli_query($conn, "DELETE FROM projects WHERE id = '$id'")) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'DB Error']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'You do not have permission to delete this.']);
    }
}
?>
