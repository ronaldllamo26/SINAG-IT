<?php
// update_db_negotiable.php
require_once 'includes/config.php';

$sql = "ALTER TABLE projects ADD COLUMN is_negotiable TINYINT(1) DEFAULT 0 AFTER price";

if ($conn->query($sql)) {
    echo "✅ Database updated: Added is_negotiable column.";
} else {
    echo "❌ Error: " . $conn->error;
}
?>
