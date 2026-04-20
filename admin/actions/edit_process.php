<?php
// admin/actions/edit_process.php
require_once '../../includes/config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']); exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = sanitize($_POST['id']);
    $title = sanitize($_POST['title']);
    $description = sanitize($_POST['description']);
    $tech_stack = sanitize($_POST['tech_stack']);
    $category = sanitize($_POST['category']);
    $badge = sanitize($_POST['badge']);
    $status = sanitize($_POST['status']);
    $price = sanitize($_POST['price']);
    $is_negotiable = isset($_POST['is_negotiable']) ? 1 : 0;
    $youtube_id = sanitize($_POST['youtube_id']);
    
    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role'];

    // Security check
    $check = mysqli_query($conn, "SELECT user_id FROM projects WHERE id = '$id'");
    $project = mysqli_fetch_assoc($check);

    if ($project['user_id'] == $user_id || $role == 'super_admin') {
        $sql = "UPDATE projects SET 
                title = '$title', 
                description = '$description', 
                tech_stack = '$tech_stack', 
                category = '$category',
                badge = '$badge',
                status = '$status',
                price = '$price', 
                is_negotiable = '$is_negotiable',
                youtube_id = '$youtube_id'
                WHERE id = '$id'";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'DB Error: ' . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    }
}
?>
