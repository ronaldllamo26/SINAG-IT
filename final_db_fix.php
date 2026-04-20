<?php
// final_db_fix.php
require_once 'includes/config.php';

echo "<h3>SINAG IT - Super Repair Mode</h3>";

// Mas robust na check
function addColumn($conn, $column, $definition) {
    $check = $conn->query("SHOW COLUMNS FROM projects LIKE '$column'");
    if ($check->num_rows == 0) {
        $sql = "ALTER TABLE projects ADD COLUMN $column $definition";
        if ($conn->query($sql)) {
            echo "✅ Success: Added column <b>$column</b>.<br>";
        } else {
            echo "❌ Error adding $column: " . $conn->error . "<br>";
        }
    } else {
        echo "ℹ️ Column <b>$column</b> already exists.<br>";
    }
}

addColumn($conn, 'price', 'DECIMAL(10,2) DEFAULT 0.00');
addColumn($conn, 'is_negotiable', 'TINYINT(1) DEFAULT 0');
addColumn($conn, 'youtube_id', 'VARCHAR(100) DEFAULT NULL');
addColumn($conn, 'video_file', 'VARCHAR(255) DEFAULT NULL');

echo "<br><b>Database is now fully synced!</b> <a href='admin/upload-project.php'>Try uploading again pre!</a>";
?>
