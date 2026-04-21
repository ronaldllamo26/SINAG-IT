<?php
// actions/save_inquiry.php
require_once '../includes/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Honeypot Check (Anti-Bot)
    if (!empty($_POST['hp_field'])) {
        // Bot detected
        echo json_encode(['status' => 'error', 'message' => 'Spam detected.']);
        exit();
    }

    // 2. Rate Limiting (Anti-Spam)
    $cooldown = 60; // seconds
    if (isset($_SESSION['last_inquiry_time'])) {
        $elapsed = time() - $_SESSION['last_inquiry_time'];
        if ($elapsed < $cooldown) {
            $wait = $cooldown - $elapsed;
            echo json_encode(['status' => 'error', 'message' => "Please wait $wait seconds before sending another message."]);
            exit();
        }
    }

    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $subject = sanitize($_POST['subject']);
    $message = sanitize($_POST['message']);
    $project_id = isset($_POST['project_id']) ? sanitize($_POST['project_id']) : 'NULL';

    $sql = "INSERT INTO inquiries (project_id, client_name, email, subject, message) 
            VALUES ($project_id, '$name', '$email', '$subject', '$message')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['last_inquiry_time'] = time();
        echo json_encode(['status' => 'success', 'message' => 'Message saved!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'DB Error: ' . mysqli_error($conn)]);
    }
}
?>
