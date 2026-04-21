<?php
// actions/track_view.php
require_once '../includes/config.php';

if (isset($_POST['id'])) {
    $id = sanitize($_POST['id']);
    // Update view count
    mysqli_query($conn, "UPDATE projects SET views = views + 1 WHERE id = '$id'");
}
