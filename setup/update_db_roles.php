<?php
// update_db_roles.php
require_once '../includes/config.php';

$sql = "ALTER TABLE users ADD COLUMN IF NOT EXISTS role VARCHAR(20) DEFAULT 'developer' AFTER full_name";

if ($conn->query($sql)) {
    // I-set ang admin_sinag as super_admin
    $conn->query("UPDATE users SET role = 'super_admin' WHERE username = 'admin_sinag'");
    echo "✅ Database updated: Roles implemented.";
} else {
    echo "❌ Error: " . $conn->error;
}
?>
