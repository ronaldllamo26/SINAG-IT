<?php
// admin/edit.php
require_once '../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = sanitize($_GET['id']);
$user_id = $_SESSION['user_id'];
$role = $_SESSION['user_role'];

// Fetch project details
if ($role == 'super_admin') {
    $query = "SELECT * FROM projects WHERE id = '$id'";
} else {
    $query = "SELECT * FROM projects WHERE id = '$id' AND user_id = '$user_id'";
}

$result = mysqli_query($conn, $query);
$project = mysqli_fetch_assoc($result);

if (!$project) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project | SINAG IT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg bg-white mb-4">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">SINAG <span class="text-primary">PORTAL</span></a>
        <a href="dashboard.php" class="btn btn-light btn-sm border"><i class="fas fa-chevron-left me-1"></i> Cancel</a>
    </div>
</nav>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="clean-card">
                <div class="p-4 border-bottom">
                    <h5 class="fw-bold mb-0">Update Project: <?= htmlspecialchars($project['title']) ?></h5>
                </div>
                <div class="p-4">
                    <form id="editForm">
                        <input type="hidden" name="id" value="<?= $project['id'] ?>">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-bold">Project Title</label>
                                <input type="text" name="title" class="form-control bg-light border-0 py-2" value="<?= htmlspecialchars($project['title']) ?>" required>
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label small fw-bold">Detailed Description</label>
                                <textarea name="description" class="form-control bg-light border-0 py-2" rows="4" required><?= htmlspecialchars($project['description']) ?></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Tech Stack</label>
                                <input type="text" name="tech_stack" class="form-control bg-light border-0 py-2" value="<?= htmlspecialchars($project['tech_stack']) ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Price (PHP)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">₱</span>
                                    <input type="number" name="price" class="form-control bg-light border-0 py-2" value="<?= $project['price'] ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">YouTube Video ID</label>
                                <input type="text" name="youtube_id" class="form-control bg-light border-0 py-2" value="<?= htmlspecialchars($project['youtube_id']) ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Status</label>
                                <select name="status" class="form-select bg-light border-0 py-2">
                                    <option value="Available" <?= $project['status'] == 'Available' ? 'selected' : '' ?>>Available</option>
                                    <option value="Sold" <?= $project['status'] == 'Sold' ? 'selected' : '' ?>>Sold</option>
                                </select>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold" id="btnSubmit">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        const btn = $('#btnSubmit');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Saving...');

        $.ajax({
            url: 'actions/edit_process.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'Updated!', text: response.message, confirmButtonColor: '#2563eb' })
                    .then(() => { window.location.href = 'dashboard.php'; });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: response.message, confirmButtonColor: '#2563eb' });
                    btn.prop('disabled', false).html('Save Changes');
                }
            }
        });
    });
</script>

</body>
</html>
