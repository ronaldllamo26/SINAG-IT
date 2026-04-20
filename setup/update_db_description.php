<?php
// update_db_description.php
require_once '../includes/config.php';

$sql = "ALTER TABLE projects MODIFY COLUMN description TEXT";

if (mysqli_query($conn, $sql)) {
    echo "✅ Database updated: Description column changed to TEXT.\n";
} else {
    echo "❌ Error updating database: " . mysqli_error($conn) . "\n";
}
?>
