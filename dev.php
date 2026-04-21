<?php
// dev.php
require_once 'includes/config.php';

$id = isset($_GET['id']) ? sanitize($_GET['id']) : header("Location: index.php");

// Fetch developer info
$dev_q = mysqli_query($conn, "SELECT full_name, email FROM users WHERE id = '$id'");
$dev = mysqli_fetch_assoc($dev_q);

if (!$dev) { header("Location: index.php"); exit; }

// Fetch projects by this dev
$query = "SELECT p.*, u.full_name as dev_name, u.email FROM projects p 
          JOIN users u ON p.user_id = u.id 
          WHERE p.user_id = '$id' AND p.status != 'Hidden' 
          ORDER BY p.created_at DESC";
$result = mysqli_query($conn, $query);
$count = mysqli_num_rows($result);

$admin_email = SITE_EMAIL;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $dev['full_name'] ?> Portfolio | SINAG IT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #6366f1; }
        .dev-hero { padding: 100px 0; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; border-radius: 0 0 60px 60px; }
        .project-card { border-radius: 30px; transition: 0.4s; overflow: hidden; border: 1px solid #f1f5f9; }
        .project-card:hover { transform: translateY(-15px); box-shadow: 0 30px 60px rgba(99, 102, 241, 0.15); }
        .badge-dev { background: rgba(99, 102, 241, 0.1); color: var(--primary); padding: 8px 15px; border-radius: 50px; font-weight: 600; font-size: 0.8rem; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg bg-white py-3 border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">SINAG <span class="text-primary">IT</span></a>
            <a href="index.php" class="btn btn-light rounded-pill px-4 border small fw-bold"><i class="fas fa-arrow-left me-2"></i> Back to Catalog</a>
        </div>
    </nav>

    <header class="dev-hero text-center mb-5">
        <div class="container">
            <div class="mb-4">
                <div class="d-inline-block p-4 rounded-circle bg-primary bg-opacity-10 mb-3" style="border: 2px solid rgba(255,255,255,0.1);">
                    <i class="fas fa-user-code fa-3x text-primary"></i>
                </div>
            </div>
            <h1 class="display-4 fw-bold mb-2"><?= $dev['full_name'] ?></h1>
            <p class="lead text-white-50 mb-0">Senior Developer at SINAG IT Solutions</p>
            <div class="mt-4 d-flex justify-content-center gap-3">
                <span class="badge-dev text-white border-white-50 border"><i class="fas fa-layer-group me-2"></i> <?= $count ?> Systems Built</span>
                <span class="badge-dev text-white border-white-50 border"><i class="fas fa-star me-2"></i> Verified Developer</span>
            </div>
        </div>
    </header>

    <section class="container py-5">
        <div class="row g-4">
            <?php if($count > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): 
                    $p_data = htmlspecialchars(json_encode([
                        'id' => $row['id'], 'title' => $row['title'], 'desc' => $row['description'],
                        'tech' => $row['tech_stack'], 'category' => $row['category'], 'price' => $row['is_negotiable'] ? 'Negotiable' : '₱'.number_format($row['price'], 2),
                        'is_neg' => $row['is_negotiable'], 'yt' => $row['youtube_id'], 'video' => $row['video_file'],
                        'dev' => $row['dev_name'], 'dev_email' => $row['email'], 'status' => $row['status']
                    ]));
                ?>
                <div class="col-md-4">
                    <div class="project-card h-100 bg-white position-relative">
                        <!-- Sold Overlay & Badge -->
                        <?php if($row['status'] == 'Sold'): ?>
                            <div class="sold-overlay"></div>
                            <div class="position-absolute top-50 start-50 translate-middle z-3 w-100 text-center">
                                <span class="sold-badge">SOLD OUT</span>
                            </div>
                        <?php endif; ?>

                        <div class="ratio ratio-16x9 bg-dark">
                            <?php if($row['video_file']): ?>
                                <video class="w-100 h-100 object-fit-cover" muted onmouseover="this.play()" onmouseout="this.pause();this.currentTime=0;">
                                    <source src="assets/videos/<?= $row['video_file'] ?>" type="video/mp4">
                                </video>
                            <?php elseif($row['youtube_id']): ?>
                                <iframe src="https://www.youtube.com/embed/<?= $row['youtube_id'] ?>?rel=0" allowfullscreen></iframe>
                            <?php else: ?>
                                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80" class="object-fit-cover">
                            <?php endif; ?>
                        </div>
                        <div class="p-4">
                            <h5 class="fw-bold mb-2"><?= $row['title'] ?></h5>
                            <div class="small text-muted mb-4"><?= $row['tech_stack'] ?></div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="fw-bold text-primary"><?= $row['is_negotiable'] ? 'Negotiable' : '₱'.number_format($row['price'], 2) ?></span>
                                <span class="badge bg-light text-muted border px-3 py-1 rounded-pill small"><?= $row['category'] ?></span>
                            </div>
                            <button class="btn btn-primary w-100 rounded-pill fw-bold btn-quickview" data-project='<?= $p_data ?>'>Details</button>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <h4 class="text-muted">No projects found for this developer.</h4>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Specs Modal (Reusable from index.php) -->
    <div class="modal fade" id="projectModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 overflow-hidden shadow-lg" style="border-radius: 40px;">
                <div class="ratio ratio-16x9 bg-dark" id="modalVideoContainer"></div>
                <div class="modal-body p-4 p-md-5">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-primary-subtle text-primary border rounded-pill px-3 py-2 small me-2" id="modalCategory">Category</span>
                                <span class="text-muted small">Built by <b id="modalDev">Developer</b></span>
                            </div>
                            <h3 class="fw-bold mb-3" id="modalTitle"></h3>
                            <div class="d-flex flex-wrap gap-2 mb-4" id="modalTech"></div>
                            <p class="text-muted mb-0" id="modalDesc" style="line-height: 1.8;"></p>
                        </div>
                        <div class="col-lg-5 ps-lg-5 text-center mt-4 mt-lg-0">
                            <div class="p-4 rounded-4 bg-light border">
                                <h2 class="fw-bold text-primary mb-1" id="modalPrice"></h2>
                                <p class="text-muted small mb-4" id="negNote"></p>
                                <a href="#" id="modalInquire" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-lg">Inquire via Email</a>
                                <p class="small text-muted mt-3 mb-0">Direct support from the developer.</p>
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
    <script src="assets/js/security.js"></script>
    <script>
        $(document).ready(function() {
            let isInquiring = false;
            $(".btn-quickview").on("click", function() {
                const p = $(this).data("project");

                // Track view
                $.post('actions/track_view.php', {id: p.id});

                $("#modalTitle").text(p.title); $("#modalDesc").text(p.desc); $("#modalPrice").text(p.price);
                $("#modalDev").text(p.dev); $("#modalCategory").text(p.category);
                $("#negNote").text(p.is_neg ? "Negotiable based on requirements." : "Fixed price.");
                $("#modalInquire").attr("data-id", p.id).attr("data-title", p.title).attr("data-email", p.dev_email);

                if (p.status === 'Sold') {
                    $("#modalInquire").addClass("disabled btn-secondary").removeClass("btn-primary").text("Sold Out");
                    $("#modalPrice").addClass("text-muted text-decoration-line-through").removeClass("text-primary");
                } else {
                    $("#modalInquire").removeClass("disabled btn-secondary").addClass("btn-primary").text("Inquire via Email");
                    $("#modalPrice").removeClass("text-muted text-decoration-line-through").addClass("text-primary");
                }
                let vHtml = p.video ? `<video class="w-100 h-100" controls autoplay muted><source src="assets/videos/${p.video}" type="video/mp4"></video>` : (p.yt ? `<iframe src="https://www.youtube.com/embed/${p.yt}?autoplay=1" allowfullscreen></iframe>` : "");
                $("#modalVideoContainer").html(vHtml);
                let tHtml = ""; p.tech.split(',').forEach(t => { tHtml += `<span class="badge bg-light text-primary border px-3 py-2 small fw-bold">${t.trim()}</span>`; });
                $("#modalTech").html(tHtml);
                $("#projectModal").modal("show");
            });

            $('#modalInquire').on('click', function(e) {
                e.preventDefault();
                const title = $(this).data('title');
                const id = $(this).data('id');
                Swal.fire({
                    title: '<h4 class="fw-bold mb-0">Inquire about ' + title + '</h4>',
                    html: `
                        <div class="text-start p-2">
                            <input type="hidden" id="swal-hp" style="display:none !important">
                            <div class="mb-3">
                                <label class="small fw-bold mb-1 text-muted">Full Name</label>
                                <input id="swal-name" class="form-control bg-light border-0 py-3 rounded-3 shadow-none" placeholder="Enter your name">
                            </div>
                            <div class="mb-3">
                                <label class="small fw-bold mb-1 text-muted">Email Address</label>
                                <input id="swal-email" type="email" class="form-control bg-light border-0 py-3 rounded-3 shadow-none" placeholder="your@email.com">
                            </div>
                            <div class="mb-1">
                                <label class="small fw-bold mb-1 text-muted">Message</label>
                                <textarea id="swal-msg" class="form-control bg-light border-0 py-3 rounded-3 shadow-none" rows="4" placeholder="How can we help you?"></textarea>
                            </div>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Send Inquiry',
                    confirmButtonColor: '#6366f1',
                    cancelButtonText: 'Cancel',
                    cancelButtonColor: '#94a3b8',
                    padding: '2rem',
                    buttonsStyling: true,
                    customClass: {
                        popup: 'rounded-4 border-0 shadow-lg',
                        confirmButton: 'btn btn-primary rounded-pill px-5 py-2 fw-bold',
                        cancelButton: 'btn btn-light rounded-pill px-4 py-2 fw-bold'
                    },
                    didOpen: () => {
                        document.getElementById('swal-name').focus();
                    },
                    preConfirm: () => { 
                        const name = document.getElementById('swal-name').value;
                        const email = document.getElementById('swal-email').value;
                        const message = document.getElementById('swal-msg').value;
                        const hp = document.getElementById('swal-hp').value;

                        if (!name || !email || !message) {
                            Swal.showValidationMessage('Please fill in all fields');
                            return false;
                        }
                        return { name, email, message, hp_field: hp };
                    },
                    willClose: () => {
                        $("#projectModal").modal("show");
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const data = result.value; data.subject = "Inquiry: " + title; data.project_id = id;
                        $.post('actions/save_inquiry.php', data, function(res) {
                            if (res.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sent!',
                                    text: 'Recorded.',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => { 
                                    let targetEmail = $(this).data('email') || '<?= $admin_email ?>';
                                    window.location.href = `mailto:${targetEmail}?subject=Inquiry: ${title}&body=${encodeURIComponent(data.message)}`; 
                                });
                            } else {
                                Swal.fire('Error', res.message, 'error');
                            }
                        }.bind(this), 'json');
                    }
                });
            });

            $('#modalInquire').on('click', function() {
                isInquiring = true;
                $("#projectModal").modal("hide");
            });

            $('#projectModal').on('hidden.bs.modal', function () { 
                if (!isInquiring) {
                    $("#modalVideoContainer").html(""); 
                }
                isInquiring = false; 
            });
        });
    </script>
</body>
</html>
