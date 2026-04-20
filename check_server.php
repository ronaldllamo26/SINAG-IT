<?php
// check_server.php
require_once 'includes/config.php';

echo "<h3>SINAG IT - Server Debug Mode</h3>";
echo "Current upload_max_filesize: " . ini_get('upload_max_filesize') . "<br>";
echo "Current post_max_size: " . ini_get('post_max_size') . "<br>";
echo "Memory Limit: " . ini_get('memory_limit') . "<br>";

$target_dir = "assets/videos/";
if (!is_dir($target_dir)) {
    echo "❌ Folder '$target_dir' does NOT exist. Creating it...<br>";
    mkdir($target_dir, 0777, true);
}

if (is_writable($target_dir)) {
    echo "✅ Folder '$target_dir' is WRITABLE.<br>";
} else {
    echo "❌ Folder '$target_dir' is NOT writable. Check permissions.<br>";
}

echo "<br><a href='index.php'>Go back</a>";
?>
