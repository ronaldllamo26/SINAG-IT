<?php
// admin/manage-developers.php
require_once '../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'super_admin') {
    header("Location: ../auth/login.php"); exit;
}

// Fetch all developers
$result = mysqli_query($conn, "SELECT id, full_name, username, email, created_at FROM users WHERE role = 'developer' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Team | SINAG IT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .dev-card { border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .btn-action { width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; transition: 0.3s; border: none; }
        .btn-reset { background: #f1f5f9; color: #64748b; }
        .btn-reset:hover { background: #6366f1; color: white; }
        .btn-delete { background: #fee2e2; color: #ef4444; }
        .btn-delete:hover { background: #ef4444; color: white; }
    </style>
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <div class="col-md-10 p-5">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h2 class="fw-bold m-0">Team Management</h2>
                <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addDevModal">
                    <i class="fas fa-plus-circle me-2"></i> Add Developer
                </button>
            </div>

            <div class="dev-card bg-white p-4">
                <h5 class="fw-bold mb-4">Registered Developers</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="text-muted small text-uppercase ls-wide">
                            <tr>
                                <th class="ps-4">Full Name</th>
                                <th>Username</th>
                                <th>Email/Gmail</th>
                                <th>Joined Date</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="ps-4 py-3 fw-bold"><?= $row['full_name'] ?></td>
                                <td class="text-primary fw-medium"><?= $row['username'] ?></td>
                                <td class="small"><?= $row['email'] ?: '<span class="text-muted italic">Not set</span>' ?></td>
                                <td class="small text-muted"><?= date('M d, Y', strtotime($row['created_at'])) ?></td>
                                <td class="text-end pe-4">
                                    <button onclick="resetPassword(<?= $row['id'] ?>, '<?= $row['full_name'] ?>')" class="btn-action btn-reset me-1" title="Reset Password">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    <button onclick="deleteDev(<?= $row['id'] ?>)" class="btn-action btn-delete" title="Delete Account">
                                        <i class="fas fa-user-minus"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Developer Modal -->
<div class="modal fade" id="addDevModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 30px;">
            <div class="modal-body p-5">
                <h4 class="fw-bold mb-4">Register New Developer</h4>
                <form id="addDevForm">
                    <div class="mb-3">
                        <label class="small fw-bold mb-2">Full Name</label>
                        <input type="text" name="full_name" class="form-control bg-light border-0 py-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold mb-2">Username</label>
                        <input type="text" name="username" class="form-control bg-light border-0 py-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold mb-2">Gmail Address (Direct Contact)</label>
                        <input type="email" name="email" class="form-control bg-light border-0 py-3" placeholder="e.g. vinzel@gmail.com" required>
                    </div>
                    <div class="mb-4">
                        <label class="small fw-bold mb-2">Initial Password</label>
                        <input type="password" name="password" class="form-control bg-light border-0 py-3" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold">Register Developer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Add Developer
    $('#addDevForm').on('submit', function(e) {
        e.preventDefault();
        $.post('actions/add_developer.php', $(this).serialize(), function(res) {
            if(res.status === 'success') {
                Swal.fire('Success!', res.message, 'success').then(() => location.reload());
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        }, 'json');
    });

    // Delete Developer
    function deleteDev(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This developer and all their projects will be removed!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Yes, remove them'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('actions/manage_dev_actions.php', {id: id, action: 'delete'}, function(res) {
                    if(res.status === 'success') {
                        location.reload();
                    }
                }, 'json');
            }
        });
    }

    // Reset Password
    function resetPassword(id, name) {
        Swal.fire({
            title: 'Reset Password for ' + name,
            input: 'text',
            inputLabel: 'New Password',
            inputPlaceholder: 'Enter new password...',
            showCancelButton: true,
            confirmButtonText: 'Update Password',
            confirmButtonColor: '#6366f1'
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                $.post('actions/manage_dev_actions.php', {id: id, action: 'reset_pw', new_password: result.value}, function(res) {
                    if(res.status === 'success') {
                        Swal.fire('Updated!', res.message, 'success');
                    }
                }, 'json');
            }
        });
    }
</script>
</body>
</html>
