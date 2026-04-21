<?php
// admin/edit-project.php
require_once '../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php"); exit;
}

$id = sanitize($_GET['id']);
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Fetch project data
$res = mysqli_query($conn, "SELECT * FROM projects WHERE id = '$id'");
$p = mysqli_fetch_assoc($res);

if (!$p || ($p['user_id'] != $user_id && $role != 'super_admin')) {
    header("Location: dashboard.php"); exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Project | SINAG IT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="col-md-10 p-5">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h2 class="fw-bold m-0">Edit Project Details</h2>
                <a href="dashboard.php" class="btn btn-light border rounded-pill px-4">Cancel</a>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="clean-card shadow-sm border-0">
                        <div class="p-4 border-bottom"><h5 class="fw-bold mb-0">Update Metadata</h5></div>
                        <div class="p-4 p-md-5">
                            <form id="editForm">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label class="small fw-bold">Project Title</label>
                                        <input type="text" name="title" class="form-control bg-light border-0 py-3" value="<?= $p['title'] ?>" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="small fw-bold">Description</label>
                                        <textarea name="description" class="form-control bg-light border-0 py-3" rows="5" required><?= $p['description'] ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold">Tech Stack</label>
                                        <input type="text" name="tech_stack" class="form-control bg-light border-0 py-3" value="<?= $p['tech_stack'] ?>" required id="techStackInput">
                                        <div class="mt-2 d-flex flex-wrap gap-2">
                                            <span class="badge bg-light text-dark border p-2 cursor-pointer tag-btn">Native PHP</span>
                                            <span class="badge bg-light text-dark border p-2 cursor-pointer tag-btn">MySQL</span>
                                            <span class="badge bg-light text-dark border p-2 cursor-pointer tag-btn">Bootstrap 5</span>
                                            <span class="badge bg-light text-dark border p-2 cursor-pointer tag-btn">HTML5/CSS3</span>
                                            <span class="badge bg-light text-dark border p-2 cursor-pointer tag-btn">JavaScript</span>
                                            <span class="badge bg-light text-dark border p-2 cursor-pointer tag-btn">AJAX</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold">Project Category</label>
                                        <input list="categoryOptions" name="category" class="form-control bg-light border-0 py-3" value="<?= $p['category'] ?>" required>
                                        <datalist id="categoryOptions">
                                            <option value="LGU & Government Systems">
                                            <option value="Logistics & Supply Chain">
                                            <option value="Finance & Accounting">
                                            <option value="Inventory Systems">
                                            <option value="School Management">
                                            <option value="E-Commerce / Retail">
                                            <option value="Custom Web Apps">
                                            <option value="Mobile Applications">
                                            <option value="Hospitality & Booking">
                                            <option value="Health & Medical Systems">
                                        </datalist>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold">Price (PHP)</label>
                                        <input type="number" name="price" class="form-control bg-light border-0 py-3" value="<?= $p['price'] ?>" <?= $p['is_negotiable'] ? 'readonly' : '' ?> id="priceInput">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" name="is_negotiable" id="isNegotiable" value="1" <?= $p['is_negotiable'] ? 'checked' : '' ?>>
                                            <label class="form-check-label small text-muted" for="isNegotiable">Negotiable</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold">Promotional Badge</label>
                                        <select name="badge" class="form-select bg-light border-0 py-3">
                                            <option value="" <?= empty($p['badge']) ? 'selected' : '' ?>>None</option>
                                            <option value="NEW" <?= $p['badge'] == 'NEW' ? 'selected' : '' ?>>NEW</option>
                                            <option value="HOT" <?= $p['badge'] == 'HOT' ? 'selected' : '' ?>>HOT</option>
                                            <option value="TOP SELLER" <?= $p['badge'] == 'TOP SELLER' ? 'selected' : '' ?>>TOP SELLER</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold">Availability Status</label>
                                        <select name="status" class="form-select bg-light border-0 py-3">
                                            <option value="Available" <?= $p['status'] == 'Available' ? 'selected' : '' ?>>Available</option>
                                            <option value="Sold" <?= $p['status'] == 'Sold' ? 'selected' : '' ?>>SOLD (Mark as finished)</option>
                                            <option value="Hidden" <?= $p['status'] == 'Hidden' ? 'selected' : '' ?>>Hidden (Draft)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold">YouTube ID</label>
                                        <input type="text" name="youtube_id" class="form-control bg-light border-0 py-3" value="<?= $p['youtube_id'] ?>">
                                    </div>
                                    <div class="col-12 pt-3">
                                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-lg">Save Changes</button>
                                    </div>
                                </div>
                            </form>
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
<script>
    // Quick Tag Selection (Toggleable)
    $('.tag-btn').on('click', function() {
        let tag = $(this).text();
        let currentVal = $('#techStackInput').val();
        let tags = currentVal.split(',').map(t => t.trim()).filter(t => t !== "");

        if (tags.includes(tag)) {
            // Remove tag
            tags = tags.filter(t => t !== tag);
            $(this).addClass('bg-light').removeClass('bg-primary text-white');
        } else {
            // Add tag
            tags.push(tag);
            $(this).removeClass('bg-light').addClass('bg-primary text-white');
        }
        
        $('#techStackInput').val(tags.join(', '));
    });

    $('#isNegotiable').on('change', function() {
        if ($(this).is(':checked')) { $('#priceInput').val('0').prop('readonly', true); } 
        else { $('#priceInput').prop('readonly', false); }
    });

    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        $.post('actions/edit_process.php', $(this).serialize(), function(res) {
            if(res.status === 'success') {
                Swal.fire('Updated!', 'Project updated successfully.', 'success').then(() => location.href = 'dashboard.php');
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        }, 'json');
    });
</script>
</body>
</html>
