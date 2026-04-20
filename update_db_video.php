<?php
// update_db_video.php
require_once 'includes/config.php';

$sql = "ALTER TABLE projects ADD COLUMN video_file VARCHAR(255) DEFAULT NULL AFTER youtube_id";

if ($conn->query($sql)) {
    echo "✅ Database updated: Added video_file column.";
} else {
    echo "❌ Error: " . $conn->error;
}
?>
