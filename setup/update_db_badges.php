<?php
// update_db_badges.php
require_once '../includes/config.php';

$sql = "ALTER TABLE projects ADD COLUMN IF NOT EXISTS badge VARCHAR(20) DEFAULT NULL AFTER category";

if ($conn->query($sql)) {
    echo "✅ Database updated: Project Badge column added.";
} else {
    echo "❌ Error: " . $conn->error;
}
?>
