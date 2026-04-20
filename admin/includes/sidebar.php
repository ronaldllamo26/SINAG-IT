<?php
// admin/includes/sidebar.php
require_once dirname(__DIR__, 2) . '/includes/config.php';

$current_page = basename($_SERVER['PHP_SELF']);
$role = $_SESSION['role'] ?? 'developer';
$user_id = $_SESSION['user_id'] ?? 0;
$is_super = ($role == 'super_admin');

// Fetch new inquiries count
// If Superadmin: Count all New
// If Developer: Count only New for their projects
if ($is_super) {
    $count_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM inquiries WHERE status = 'New'");
} else {
    $count_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM inquiries 
                                    WHERE status = 'New' 
                                    AND project_id IN (SELECT id FROM projects WHERE user_id = '$user_id')");
}
$count_data = mysqli_fetch_assoc($count_q);
$new_count = $count_data['total'];
?>
<div class="col-md-2 sidebar d-none d-md-block sticky-top">
    <h4 class="fw-bold mb-5 ps-2">SINAG <span class="text-primary">IT</span></h4>
    
    <a href="dashboard.php" class="nav-link-custom <?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">
        <i class="fas fa-home"></i> Dashboard
    </a>
    
    <a href="upload-project.php" class="nav-link-custom <?= ($current_page == 'upload-project.php') ? 'active' : '' ?>">
        <i class="fas fa-plus-circle"></i> Add Project
    </a>

    <!-- Inquiries for everyone (but content is filtered) -->
    <a href="inquiries.php" class="nav-link-custom <?= ($current_page == 'inquiries.php') ? 'active' : '' ?> position-relative">
        <i class="fas fa-envelope-open-text"></i> Inquiries
        <?php if($new_count > 0): ?>
            <span class="position-absolute top-50 start-100 translate-middle badge rounded-pill bg-danger" style="margin-left: -20px; font-size: 0.6rem;">
                <?= $new_count ?>
            </span>
        <?php endif; ?>
    </a>
    
    <?php if($is_super): ?>
    <div class="mt-4 mb-2 small text-muted fw-bold ps-3 text-uppercase ls-wide">Management</div>
    <a href="manage-developers.php" class="nav-link-custom <?= ($current_page == 'manage-developers.php') ? 'active' : '' ?>">
        <i class="fas fa-users"></i> Developers
    </a>
    <?php endif; ?>

    <div class="mt-auto pt-5">
        <a href="../index.php" class="nav-link-custom"><i class="fas fa-external-link-alt"></i> View Site</a>
        <a href="../auth/logout.php" class="nav-link-custom text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

<style>
    .sidebar { background: white; border-right: 1px solid #f1f5f9; min-height: 100vh; padding: 30px 20px; display: flex; flex-direction: column; }
    .nav-link-custom { display: flex; align-items: center; padding: 12px 15px; color: #64748b; border-radius: 12px; text-decoration: none; margin-bottom: 5px; transition: 0.3s; font-weight: 500; }
    .nav-link-custom:hover, .nav-link-custom.active { background: #6366f1; color: white; box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2); }
    .nav-link-custom i { margin-right: 12px; width: 20px; text-align: center; }
</style>
