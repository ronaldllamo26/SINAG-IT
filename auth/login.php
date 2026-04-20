<?php
// auth/login.php
require_once '../includes/config.php';

if (isset($_SESSION['user_id'])) {
    header("Location: ../admin/dashboard.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim(sanitize($_POST['username']));
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, username, password, full_name, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['role'] = $row['role'];
            
            header("Location: ../admin/dashboard.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SINAG IT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="text-center mb-4">
                <h2 class="fw-bold">SINAG <span class="text-primary">IT</span></h2>
                <p class="text-muted small">Internal Portal Access</p>
            </div>
            
            <div class="clean-card p-4">
                <form action="" method="POST">
                    <?php if($error): ?>
                        <div class="alert alert-danger py-2 small border-0 bg-danger-subtle text-danger">
                            <?= $error; ?>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Username</label>
                        <input type="text" name="username" class="form-control bg-light border-0 py-2" placeholder="Your username" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control bg-light border-0 py-2" placeholder="Your password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">
                        Sign In
                    </button>
                    
                    <div class="text-center mt-4">
                        <a href="../index.php" class="text-muted text-decoration-none small">
                            <i class="fas fa-arrow-left me-1"></i> Return to Site
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
