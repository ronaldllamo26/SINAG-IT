<?php
// admin/profile.php
require_once '../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php"); exit;
}

$user_id = $_SESSION['user_id'];
$res = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$u = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile Settings | SINAG IT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <div class="col-md-10 p-5">
            <h2 class="fw-bold mb-5">Profile Settings</h2>

            <div class="row">
                <div class="col-lg-6">
                    <div class="clean-card shadow-sm border-0">
                        <div class="p-4 border-bottom"><h5 class="fw-bold mb-0">Update Information</h5></div>
                        <div class="p-4 p-md-5">
                            <form id="profileForm">
                                <div class="mb-4">
                                    <label class="small fw-bold mb-2">Full Name</label>
                                    <input type="text" name="full_name" class="form-control bg-light border-0 py-3" value="<?= $u['full_name'] ?>" required>
                                </div>
                                <div class="mb-4">
                                    <label class="small fw-bold mb-2">Gmail Address (For Inquiries)</label>
                                    <input type="email" name="email" class="form-control bg-light border-0 py-3" value="<?= $u['email'] ?>" required>
                                    <div class="small text-muted mt-1">This is where clients will contact you.</div>
                                </div>
                                <hr class="my-4 opacity-10">
                                <div class="mb-4">
                                    <label class="small fw-bold mb-2">New Password (Leave blank to keep current)</label>
                                    <input type="password" name="new_password" class="form-control bg-light border-0 py-3" placeholder="••••••••">
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-lg mt-3">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <div class="alert alert-info border-0 rounded-4 p-4 shadow-sm">
                        <div class="d-flex">
                            <i class="fas fa-info-circle fa-2x me-3"></i>
                            <div>
                                <h6 class="fw-bold">Why update your Gmail?</h6>
                                <p class="small mb-0 opacity-75">Our new decentralized system routes client inquiries directly to the email address set here. Make sure it's an active Gmail account where you can reply to clients promptly.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../assets/js/security.js"></script>
<script>
    $('#profileForm').on('submit', function(e) {
        e.preventDefault();
        $.post('actions/update_profile.php', $(this).serialize(), function(res) {
            if(res.status === 'success') {
                Swal.fire('Updated!', 'Your profile has been updated.', 'success').then(() => location.reload());
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        }, 'json');
    });
</script>
</body>
</html>
