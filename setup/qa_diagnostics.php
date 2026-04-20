<?php
// qa_diagnostics.php
require_once '../includes/config.php';

echo "=== SINAG IT SYSTEM DIAGNOSTICS ===\n";

// 1. Database Connectivity
if($conn) {
    echo "[PASS] Database Connected: " . DB_NAME . "\n";
} else {
    echo "[FAIL] Database Connection Error\n";
}

// 2. Table Column Check
$tables = [
    'projects' => ['badge', 'status', 'is_negotiable', 'user_id'],
    'users' => ['role', 'full_name'],
    'inquiries' => ['status', 'project_id']
];

foreach ($tables as $table => $columns) {
    foreach ($columns as $col) {
        $res = mysqli_query($conn, "SHOW COLUMNS FROM $table LIKE '$col'");
        if(mysqli_num_rows($res) > 0) {
            echo "[PASS] Table '$table' has column '$col'\n";
        } else {
            echo "[FAIL] Table '$table' MISSING column '$col'\n";
        }
    }
}

// 3. User Check
$res = mysqli_query($conn, "SELECT COUNT(*) as count FROM users");
$row = mysqli_fetch_assoc($res);
echo "[INFO] Total Users: " . $row['count'] . "\n";

// 4. Project Check
$res = mysqli_query($conn, "SELECT COUNT(*) as count FROM projects");
$row = mysqli_fetch_assoc($res);
echo "[INFO] Total Projects: " . $row['count'] . "\n";

echo "=== DIAGNOSTICS COMPLETE ===\n";
?>
