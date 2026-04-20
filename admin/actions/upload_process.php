<?php
// admin/actions/upload_process.php
require_once '../../includes/config.php';

header('Content-Type: application/json');

// Check if POST is empty (usually happens when file size exceeds post_max_size)
if (empty($_POST) && $_SERVER['CONTENT_LENGTH'] > 0) {
    echo json_encode(['status' => 'error', 'message' => 'File is too large for the server. Please use YouTube ID instead.']);
    exit();
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = isset($_POST['title']) ? sanitize($_POST['title']) : '';
    $description = isset($_POST['description']) ? sanitize($_POST['description']) : '';
    $tech_stack = isset($_POST['tech_stack']) ? sanitize($_POST['tech_stack']) : '';
    $category = isset($_POST['category']) ? sanitize($_POST['category']) : '';
    $badge = isset($_POST['badge']) ? sanitize($_POST['badge']) : '';
    $price = isset($_POST['price']) ? sanitize($_POST['price']) : 0;
    $is_negotiable = isset($_POST['is_negotiable']) ? 1 : 0;
    $youtube_id = isset($_POST['youtube_id']) ? sanitize($_POST['youtube_id']) : '';
    $user_id = $_SESSION['user_id'];

    if (empty($title)) {
        echo json_encode(['status' => 'error', 'message' => 'Project title is required.']);
        exit();
    }

    $video_file_name = null;

    if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../../assets/videos/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

        $file_ext = strtolower(pathinfo($_FILES["video_file"]["name"], PATHINFO_EXTENSION));
        $new_file_name = time() . "_" . preg_replace("/[^a-zA-Z0-9]/", "", $title) . "." . $file_ext;
        
        if (move_uploaded_file($_FILES["video_file"]["tmp_name"], $target_dir . $new_file_name)) {
            $video_file_name = $new_file_name;
        }
    } elseif (isset($_FILES['video_file']) && $_FILES['video_file']['error'] !== UPLOAD_ERR_NO_FILE) {
        echo json_encode(['status' => 'error', 'message' => 'Video upload failed. Error code: ' . $_FILES['video_file']['error']]);
        exit();
    }

    $sql = "INSERT INTO projects (user_id, title, description, tech_stack, category, badge, price, is_negotiable, youtube_id, video_file, status) 
            VALUES ('$user_id', '$title', '$description', '$tech_stack', '$category', '$badge', '$price', '$is_negotiable', '$youtube_id', '$video_file_name', 'Available')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Project published!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'DB error: ' . mysqli_error($conn)]);
    }
}
?>
