<?php
// debug_db.php
require_once 'includes/config.php';

echo "<h3>Database Debugger</h3>";

// 1. Check Table Structure
$result = $conn->query("DESCRIBE users");
echo "<h4>Table 'users' Structure:</h4><table border='1' cellpadding='5' style='border-collapse: collapse;'><tr><th>Field</th><th>Type</th></tr>";
while($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['Field']}</td><td>{$row['Type']}</td></tr>";
}
echo "</table>";

// 2. Fix Password Length if needed
echo "<h4>Fixing structure...</h4>";
if ($conn->query("ALTER TABLE users MODIFY COLUMN password VARCHAR(255) NOT NULL")) {
    echo "✅ Password column updated to VARCHAR(255)<br>";
} else {
    echo "❌ Error updating column: " . $conn->error . "<br>";
}

// 3. Re-insert Admin with fresh hash
$username = 'admin_sinag';
$password = 'password123';
$hashed = password_hash($password, PASSWORD_DEFAULT);

$conn->query("DELETE FROM users WHERE username = '$username'"); // Clear existing
$sql = "INSERT INTO users (username, password, full_name, role) VALUES ('$username', '$hashed', 'SINAG Admin', 'Admin')";

if ($conn->query($sql)) {
    echo "✅ Admin account re-created with fresh hash.<br>";
} else {
    echo "❌ Error re-creating admin: " . $conn->error . "<br>";
}

echo "<br><a href='auth/login.php'>Subukan mo ulit mag-Login dito</a>";
?>
