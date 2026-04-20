<?php
// reset_admin.php
require_once '../includes/config.php';

// Gamitin natin ang 'super_admin' dahil yun ang nasa ENUM mo
$username = 'admin_sinag';
$password = 'admin123'; // Simple password muna pang test
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$full_name = 'SINAG Super Admin';
$role = 'super_admin'; 

// Siguraduhin nating malinis ang table bago mag insert
$conn->query("DELETE FROM users WHERE username = '$username'");

$sql = "INSERT INTO users (username, password, full_name, role) VALUES ('$username', '$hashed_password', '$full_name', '$role')";

if ($conn->query($sql)) {
    echo "<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>";
    echo "<h2>✅ Success! Admin Account Fixed</h2>";
    echo "<p><b>Username:</b> <code style='background:#eee;padding:2px 5px;'>$username</code></p>";
    echo "<p><b>New Password:</b> <code style='background:#eee;padding:2px 5px;'>$password</code></p>";
    echo "<p><b>Role:</b> $role</p>";
    echo "<hr style='width:200px'>";
    echo "<p>Test logic: " . (password_verify($password, $hashed_password) ? "✅ Hash working" : "❌ Hash failed") . "</p>";
    echo "<br><a href='auth/login.php' style='padding: 10px 20px; background: #2563eb; color: white; text-decoration: none; border-radius: 5px;'>Proceed to Login</a>";
    echo "</div>";
} else {
    echo "Error: " . $conn->error;
}
?>
