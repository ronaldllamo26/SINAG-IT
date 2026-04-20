<?php
// admin/inquiries.php
require_once '../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php"); exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

if ($role == 'super_admin') {
    $query = "SELECT i.*, p.title as project_title FROM inquiries i 
              LEFT JOIN projects p ON i.project_id = p.id 
              ORDER BY i.created_at DESC";
} else {
    $query = "SELECT i.*, p.title as project_title 
              FROM inquiries i 
              JOIN projects p ON i.project_id = p.id 
              WHERE p.user_id = '$user_id' 
              ORDER BY i.created_at DESC";
}
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales & Inquiry Tracker | SINAG IT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <div class="col-md-10 p-5">
            <h2 class="fw-bold mb-5"><?= ($role == 'super_admin') ? 'Company' : 'Your' ?> Sales Tracker</h2>

            <div class="clean-card shadow-sm border-0">
                <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Client Leads</h5>
                    <div class="d-flex gap-3">
                        <span class="small"><i class="fas fa-circle text-primary me-1"></i> New</span>
                        <span class="small"><i class="fas fa-circle text-success me-1"></i> Replied</span>
                        <span class="small"><i class="fas fa-circle text-warning me-1"></i> Closed/Sold</span>
                    </div>
                </div>
                <div class="p-0 table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light small text-uppercase fw-bold">
                            <tr>
                                <th class="ps-4 py-3">Client</th>
                                <th class="py-3">Project</th>
                                <th class="py-3">Message</th>
                                <th class="py-3">Status</th>
                                <th class="pe-4 py-3 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($result) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($result)): 
                                    $status = $row['status'];
                                    $row_class = "";
                                    $badge_class = "bg-secondary";
                                    
                                    if($status == 'New') { $row_class = "bg-primary bg-opacity-10"; $badge_class = "bg-primary"; }
                                    elseif($status == 'Replied') { $row_class = "bg-success bg-opacity-10"; $badge_class = "bg-success"; }
                                    elseif($status == 'Closed') { $row_class = "bg-warning bg-opacity-10"; $badge_class = "bg-warning"; }
                                ?>
                                <tr class="<?= $row_class ?>">
                                    <td class="ps-4 py-4">
                                        <div class="fw-bold"><?= $row['client_name'] ?></div>
                                        <div class="small text-muted"><?= $row['email'] ?></div>
                                    </td>
                                    <td>
                                        <span class="badge bg-white text-dark border fw-medium"><?= $row['project_title'] ?? $row['subject'] ?></span>
                                    </td>
                                    <td style="max-width: 250px;">
                                        <p class="small mb-0 text-truncate" title="<?= $row['message'] ?>"><?= $row['message'] ?></p>
                                    </td>
                                    <td>
                                        <span class="badge <?= $badge_class ?> rounded-pill" style="font-size: 0.6rem;"><?= strtoupper($status) ?></span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <div class="btn-group shadow-sm rounded-pill overflow-hidden">
                                            <?php if($status == 'New' || $status == 'Read'): ?>
                                                <button onclick="updateStatus(<?= $row['id'] ?>, 'Replied')" class="btn btn-white btn-sm border-end px-3" title="Mark as Replied"><i class="fas fa-reply text-success"></i></button>
                                            <?php endif; ?>
                                            
                                            <?php if($status != 'Closed'): ?>
                                                <button onclick="updateStatus(<?= $row['id'] ?>, 'Closed')" class="btn btn-white btn-sm border-end px-3" title="Mark as Closed/Sold"><i class="fas fa-check-double text-warning"></i></button>
                                            <?php endif; ?>
                                            
                                            <a href="mailto:<?= $row['email'] ?>?subject=RE: <?= $row['subject'] ?>" class="btn btn-white btn-sm px-3" title="Send Email"><i class="fas fa-envelope text-primary"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center py-5 text-muted">No leads found yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function updateStatus(id, status) {
    $.post('actions/mark_inquiry_read.php', {id: id, status: status}, function(res) {
        if(res.status === 'success') {
            location.reload();
        }
    }, 'json');
}
</script>
<style>
    .btn-white { background: white; color: #64748b; }
    .btn-white:hover { background: #f8fafc; color: #1e293b; }
</style>
</body>
</html>
