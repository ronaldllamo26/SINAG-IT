<?php
// admin/dashboard.php
require_once '../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Auto-fix session if role is missing
if (!isset($_SESSION['role'])) {
    $role_q = mysqli_query($conn, "SELECT role FROM users WHERE id = '$user_id'");
    if ($row = mysqli_fetch_assoc($role_q)) {
        $_SESSION['role'] = $row['role'];
    }
}

$is_super = ($_SESSION['role'] == 'super_admin');

// Fetch user info
$user_q = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($user_q);

// Fetch projects
if ($is_super) {
    // Superadmin sees everything
    $query = "SELECT p.*, u.full_name as dev_name FROM projects p 
              JOIN users u ON p.user_id = u.id 
              ORDER BY p.created_at DESC";
} else {
    // Developers see only their own
    $query = "SELECT p.*, u.full_name as dev_name FROM projects p 
              JOIN users u ON p.user_id = u.id 
              WHERE p.user_id = '$user_id' 
              ORDER BY p.created_at DESC";
}
$result = mysqli_query($conn, $query);

// Analytics Data: Inquiries (Last 7 Days)
$inquiry_days = [];
$inquiry_counts = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $date_label = date('M d', strtotime("-$i days"));
    $q = mysqli_query($conn, "SELECT COUNT(*) as total FROM inquiries WHERE DATE(created_at) = '$date'");
    $r = mysqli_fetch_assoc($q);
    $inquiry_days[] = $date_label;
    $inquiry_counts[] = $r['total'];
}

// Analytics Data: Projects by Category
$cat_labels = [];
$cat_counts = [];
$cat_q = mysqli_query($conn, "SELECT category, COUNT(*) as total FROM projects GROUP BY category");
while($cat_r = mysqli_fetch_assoc($cat_q)) {
    $cat_labels[] = $cat_r['category'];
    $cat_counts[] = $cat_r['total'];
}

// Developer Personal Stats
if (!$is_super) {
    $dev_projects = mysqli_num_rows($result);
    $dev_inquiries_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM inquiries WHERE project_id IN (SELECT id FROM projects WHERE user_id = '$user_id')");
    $dev_inquiries = mysqli_fetch_assoc($dev_inquiries_q)['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | SINAG IT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar { background: white; border-right: 1px solid #f1f5f9; min-height: 100vh; padding: 30px 20px; }
        .nav-link-custom { display: flex; align-items: center; padding: 12px 15px; color: #64748b; border-radius: 12px; text-decoration: none; margin-bottom: 5px; transition: 0.3s; }
        .nav-link-custom:hover, .nav-link-custom.active { background: #6366f1; color: white; }
        .nav-link-custom i { margin-right: 12px; width: 20px; text-align: center; }
        .stat-card { border-radius: 20px; padding: 25px; background: white; border: 1px solid #f1f5f9; }
    </style>
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="col-md-10 p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h2 class="fw-bold mb-1">Welcome back, <?= $user['full_name'] ?>!</h2>
                    <p class="text-muted mb-0">Role: <span class="badge bg-primary rounded-pill"><?= strtoupper($user['role']) ?></span></p>
                </div>
                <a href="upload-project.php" class="btn btn-primary px-4 py-2 rounded-pill fw-bold shadow-sm">
                    <i class="fas fa-plus me-2"></i> New Project
                </a>
            </div>

            <!-- Developer Stats (Only for non-superadmin) -->
            <?php if(!$is_super): ?>
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <div class="stat-card shadow-sm border-0 bg-primary text-white">
                        <div class="small mb-1 fw-bold text-uppercase opacity-75">Your Projects</div>
                        <h2 class="fw-bold mb-0"><?= $dev_projects ?></h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-card shadow-sm border-0 bg-white">
                        <div class="text-muted small mb-1 fw-bold text-uppercase">Total Leads for You</div>
                        <h2 class="fw-bold mb-0"><?= $dev_inquiries ?></h2>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Analytics Section -->
            <div class="row g-4 mb-5">
                <div class="col-lg-8">
                    <div class="stat-card shadow-sm h-100">
                        <h6 class="fw-bold mb-4">Inquiry Trends (Last 7 Days)</h6>
                        <canvas id="inquiryChart" height="100"></canvas>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="stat-card shadow-sm h-100">
                        <h6 class="fw-bold mb-4">Systems by Category</h6>
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Project Table -->
            <div class="clean-card shadow-sm border-0">
                <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Manage Systems Catalog</h5>
                </div>
                <div class="p-0 table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 border-0 py-3 small text-muted text-uppercase fw-bold">Project</th>
                                <th class="border-0 py-3 small text-muted text-uppercase fw-bold">Tech Stack</th>
                                <th class="border-0 py-3 small text-muted text-uppercase fw-bold">Price</th>
                                <th class="border-0 py-3 small text-muted text-uppercase fw-bold">Developer</th>
                                <th class="border-0 py-3 small text-muted text-uppercase fw-bold">Status</th>
                                <th class="pe-4 border-0 py-3 small text-muted text-uppercase fw-bold text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="ps-4 py-4">
                                    <div class="fw-bold"><?= $row['title'] ?></div>
                                    <div class="small text-muted">ID: #<?= $row['id'] ?></div>
                                </td>
                                <td><span class="badge bg-light text-primary border"><?= $row['tech_stack'] ?></span></td>
                                <td>
                                    <div class="fw-bold"><?= $row['is_negotiable'] ? 'Negotiable' : '₱'.number_format($row['price'], 2) ?></div>
                                </td>
                                <td><div class="small fw-medium"><?= $row['dev_name'] ?></div></td>
                                <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Available</span></td>
                                <td class="pe-4 text-end">
                                    <a href="edit-project.php?id=<?= $row['id'] ?>" class="btn btn-light btn-sm rounded-circle me-1" title="Edit"><i class="fas fa-edit text-primary"></i></a>
                                    <button onclick="deleteProject(<?= $row['id'] ?>)" class="btn btn-light btn-sm rounded-circle" title="Delete"><i class="fas fa-trash text-danger"></i></button>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Inquiry Trends Chart
const ctxInquiry = document.getElementById('inquiryChart').getContext('2d');
new Chart(ctxInquiry, {
    type: 'line',
    data: {
        labels: <?= json_encode($inquiry_days) ?>,
        datasets: [{
            label: 'Inquiries',
            data: <?= json_encode($inquiry_counts) ?>,
            borderColor: '#6366f1',
            backgroundColor: 'rgba(99, 102, 241, 0.1)',
            fill: true,
            tension: 0.4
        }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
});

// Category Distribution Chart
const ctxCategory = document.getElementById('categoryChart').getContext('2d');
new Chart(ctxCategory, {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($cat_labels) ?>,
        datasets: [{
            data: <?= json_encode($cat_counts) ?>,
            backgroundColor: ['#6366f1', '#8b5cf6', '#3b82f6', '#0ea5e9', '#f43f5e']
        }]
    },
    options: { plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } } } }
});

function deleteProject(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6366f1',
        cancelButtonColor: '#94a3b8',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('actions/delete_project.php', {id: id}, function(res) {
                if(res.status === 'success') {
                    Swal.fire('Deleted!', 'Project has been removed.', 'success').then(() => location.reload());
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }, 'json');
        }
    });
}
</script>
</body>
</html>
