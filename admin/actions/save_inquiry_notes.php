<?php
// admin/actions/save_inquiry_notes.php
require_once '../../includes/config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = sanitize($_POST['id']);
    $notes = sanitize($_POST['notes']);

    $sql = "UPDATE inquiries SET admin_notes = '$notes' WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Notes saved!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'DB Error: ' . mysqli_error($conn)]);
    }
}
?>
