<?php
// actions/save_inquiry.php
require_once '../includes/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $subject = sanitize($_POST['subject']);
    $message = sanitize($_POST['message']);
    $project_id = isset($_POST['project_id']) ? sanitize($_POST['project_id']) : 'NULL';

    $sql = "INSERT INTO inquiries (project_id, client_name, email, subject, message) 
            VALUES ($project_id, '$name', '$email', '$subject', '$message')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Message saved!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'DB Error: ' . mysqli_error($conn)]);
    }
}
?>
