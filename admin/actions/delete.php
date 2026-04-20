<?php
// admin/actions/delete.php
require_once '../../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = sanitize($_GET['id']);
    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['user_role'];

    // RBAC: Only owner or Super Admin can delete
    if ($role == 'super_admin') {
        $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->bind_param("i", $id);
    } else {
        $stmt = $conn->prepare("DELETE FROM projects WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $user_id);
    }

    if ($stmt->execute()) {
        header("Location: ../dashboard.php?msg=deleted");
    } else {
        header("Location: ../dashboard.php?msg=error");
    }
    $stmt->close();
}
?>
