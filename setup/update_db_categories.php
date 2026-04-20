<?php
// update_db_categories.php
require_once '../includes/config.php';

$sql = "ALTER TABLE projects ADD COLUMN IF NOT EXISTS category VARCHAR(50) DEFAULT 'General' AFTER tech_stack";

if ($conn->query($sql)) {
    echo "✅ Database updated: Category column added.";
} else {
    echo "❌ Error: " . $conn->error;
}
?>
