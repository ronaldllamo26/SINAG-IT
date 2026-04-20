<?php
// update_db_inquiries.php
require_once 'includes/config.php';

$sql = "CREATE TABLE IF NOT EXISTS inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT DEFAULT NULL,
    client_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255),
    message TEXT,
    status ENUM('New', 'Read', 'Replied') DEFAULT 'New',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql)) {
    echo "✅ Database updated: Inquiries table created.";
} else {
    echo "❌ Error: " . $conn->error;
}
?>
