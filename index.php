<?php
// index.php
require_once 'includes/config.php';

// Fetch projects
$query = "SELECT p.*, u.full_name as dev_name FROM projects p 
          JOIN users u ON p.user_id = u.id 
          WHERE p.status = 'Available' 
          ORDER BY p.created_at DESC";
$result = mysqli_query($conn, $query);

$admin_email = "campusthrift77@gmail.com";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SINAG IT | Professional Software Solutions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #6366f1; --primary-light: #e0e7ff; }
        .hero-section { padding: 100px 0; background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 100%); overflow: hidden; }
        .hero-img { border-radius: 40px; box-shadow: 0 30px 60px rgba(0,0,0,0.1); transform: perspective(1000px) rotateY(-5deg); transition: 0.5s; }
        .hero-img:hover { transform: perspective(1000px) rotateY(0deg); }
        .brand-text { font-weight: 800; letter-spacing: 1px; color: #1e293b; }
        .brand-it { color: var(--primary); margin-left: 5px; font-weight: 400; border-left: 2px solid #e2e8f0; padding-left: 8px; }
        .feature-card { transition: 0.3s; padding: 40px; border-radius: 30px; }
        .feature-card:hover { background: white; box-shadow: 0 20px 40px rgba(0,0,0,0.05); }
        .search-input { border-radius: 50px; padding: 15px 30px; padding-left: 55px; border: 1px solid #e2e8f0; background: #f8fafc; }
        .project-card { border-radius: 30px; transition: 0.4s; overflow: hidden; }
        .project-card:hover { transform: translateY(-15px); box-shadow: 0 30px 60px rgba(99, 102, 241, 0.15); }
        .bg-dots { background-image: radial-gradient(#6366f1 0.5px, transparent 0.5px); background-size: 24px 24px; }
        
    </style>
</head>
<body class="bg-dots">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top bg-white py-3 border-bottom border-light">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <span class="brand-text">SINAG</span><span class="brand-it">IT</span>
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link px-3 fw-medium" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link px-3 fw-medium" href="#catalog">Catalog</a></li>
                    <li class="nav-item ms-lg-3">
                        <a href="#contact" class="btn btn-primary rounded-pill px-4 fw-bold shadow-lg">Inquire Now</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <style>
        .brand-text { font-weight: 800; letter-spacing: 1px; color: #1e293b; font-size: 1.5rem; }
        .brand-it { color: var(--primary); margin-left: 5px; font-weight: 400; border-left: 2px solid #e2e8f0; padding-left: 8px; font-size: 1.5rem; }
    </style>

    <!-- Hero Section -->
    <header id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h6 class="text-primary fw-bold text-uppercase small mb-3">Academic & Business Solutions</h6>
                    <h1 class="display-3 fw-bold mb-4" style="color: #0f172a;">Smart Systems for Students & Businesses</h1>
                    <p class="lead text-muted mb-5 pe-lg-5">Helping students excel in their academic projects and businesses automate their daily operations with high-quality, ready-to-deploy software.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#catalog" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow-lg">Browse Systems</a>
                        <a href="#contact" class="btn btn-light btn-lg rounded-pill px-5 fw-bold border bg-white">Thesis Consultation</a>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1000&q=80" class="img-fluid hero-img" alt="SINAG IT Solutions">
                </div>
            </div>
        </div>
    </header>

    <!-- Benefits Section -->
    <section class="py-5 bg-white">
        <div class="container py-5">
            <div class="row g-4 text-center">
                <div class="col-md-6">
                    <div class="feature-card h-100 p-5">
                        <div class="icon-box mb-4 mx-auto">
                            <i class="fas fa-graduation-cap fa-2x text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-3">For Students</h3>
                        <p class="text-muted">Get a solid foundation for your capstone or thesis projects with our clean and well-documented source codes.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="feature-card h-100 p-5">
                        <div class="icon-box mb-4 mx-auto">
                            <i class="fas fa-briefcase fa-2x text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-3">For Businesses</h3>
                        <p class="text-muted">Professional systems designed to manage inventory, sales, and operations with ease and reliability.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .feature-card {
            background: white;
            border: 1px solid #f1f5f9;
            border-radius: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            cursor: default;
        }
        .feature-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 40px 80px rgba(99, 102, 241, 0.12);
            border-color: rgba(99, 102, 241, 0.2);
        }
        .icon-box {
            width: 80px;
            height: 80px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 25px;
            transition: 0.3s;
        }
        .feature-card:hover .icon-box {
            background: #6366f1;
            color: white;
            transform: rotate(10deg);
        }
        .feature-card:hover .icon-box i {
            color: white !important;
        }
    </style>

    <!-- Catalog -->
    <section id="catalog" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold display-5 mb-4">Ready-to-Deploy Systems</h2>
                
                <!-- Category Tabs -->
                <div class="d-flex justify-content-center flex-wrap gap-2 mb-4">
                    <button class="btn btn-primary rounded-pill px-4 cat-filter active" data-cat="all">All Systems</button>
                    <button class="btn btn-outline-primary rounded-pill px-4 cat-filter" data-cat="Inventory">Inventory</button>
                    <button class="btn btn-outline-primary rounded-pill px-4 cat-filter" data-cat="School">School</button>
                    <button class="btn btn-outline-primary rounded-pill px-4 cat-filter" data-cat="E-Commerce">E-Commerce</button>
                    <button class="btn btn-outline-primary rounded-pill px-4 cat-filter" data-cat="Web App">Web Apps</button>
                </div>

                <div class="d-flex justify-content-center">
                    <div class="position-relative w-100" style="max-width: 600px;">
                        <i class="fas fa-search position-absolute" style="left: 25px; top: 18px; color: #94a3b8;"></i>
                        <input type="text" id="searchInput" class="form-control search-input" placeholder="Search by title or technology...">
                    </div>
                </div>
            </div>

            <div class="row g-4" id="projectContainer">
                <?php 
                $result = mysqli_query($conn, "SELECT p.*, u.full_name as dev_name FROM projects p JOIN users u ON p.user_id = u.id WHERE p.status != 'Hidden' ORDER BY p.created_at DESC");
                while($row = mysqli_fetch_assoc($result)): 
                    $p_data = htmlspecialchars(json_encode([
                        'id' => $row['id'], 'title' => $row['title'], 'desc' => $row['description'],
                        'tech' => $row['tech_stack'], 'category' => $row['category'], 'price' => $row['is_negotiable'] ? 'Negotiable' : '₱'.number_format($row['price'], 2),
                        'is_neg' => $row['is_negotiable'], 'yt' => $row['youtube_id'], 'video' => $row['video_file'],
                        'dev' => $row['dev_name']
                    ]));
                ?>
                    <div class="col-md-4 project-item" data-category="<?= $row['category'] ?>" data-title="<?= strtolower($row['title']) ?>" data-tech="<?= strtolower($row['tech_stack']) ?>">
                        <div class="project-card h-100 bg-white border-0 shadow-sm position-relative">
                            
                            <!-- Promo Badge -->
                            <?php if(isset($row['badge']) && !empty($row['badge'])): ?>
                                <span class="badge position-absolute top-0 start-0 m-3 z-3 shadow-sm <?= ($row['badge'] == 'HOT') ? 'bg-danger' : 'bg-primary' ?>" style="font-size: 0.7rem; letter-spacing: 1px;">
                                    <?= $row['badge'] ?>
                                </span>
                            <?php endif; ?>

                            <!-- Sold Badge -->
                            <?php if(isset($row['status']) && $row['status'] == 'Sold'): ?>
                                <div class="position-absolute top-50 start-50 translate-middle z-3 w-100 text-center">
                                    <span class="badge bg-dark px-4 py-2 shadow-lg" style="opacity: 0.9; font-size: 1rem; border: 2px solid white;">SOLD</span>
                                </div>
                            <?php endif; ?>

                            <div class="ratio ratio-16x9 bg-dark <?= ($row['status'] == 'Sold') ? 'opacity-50' : '' ?>">
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
                                <div class="small text-muted mb-3"><?= $row['tech_stack'] ?></div>
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="fw-bold text-primary"><?= $row['is_negotiable'] ? 'Negotiable' : '₱'.number_format($row['price'], 2) ?></span>
                                    <div class="small text-muted"><i class="fas fa-code-branch me-1"></i> <a href="dev.php?id=<?= $row['user_id'] ?>" class="text-muted text-decoration-none hover-primary"><?= explode(' ', $row['dev_name'])[0] ?></a></div>
                                </div>
                                <button class="btn btn-primary w-100 rounded-pill fw-bold btn-quickview" data-project='<?= $p_data ?>'>
                                    Details
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Specs Modal -->
    <div class="modal fade" id="projectModal" tabindex="-1" aria-hidden="true">
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

    <!-- Why Choose Us Section -->
    <section class="py-5 bg-white mt-5">
        <div class="container py-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="position-relative">
                        <div class="position-absolute top-0 start-0 bg-primary w-100 h-100 rounded-5 mt-3 ms-3" style="opacity: 0.1; z-index: 0;"></div>
                        <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=800&q=80" class="img-fluid rounded-5 shadow-lg position-relative z-1" alt="Development">
                    </div>
                </div>
                <div class="col-lg-6 text-start">
                    <h6 class="text-primary fw-bold text-uppercase mb-3 ls-wide">Premium Solutions</h6>
                    <h2 class="display-5 fw-bold mb-4">Crafting Digital Excellence for Your Business</h2>
                    <p class="lead text-muted mb-5 text-start">We are a team of dedicated developers committed to providing high-quality source codes and software solutions tailored for your academic and business needs.</p>
                    <div class="row g-4 text-start">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-check-circle text-primary me-2"></i>
                                <span class="fw-bold">Expert Developers</span>
                            </div>
                            <p class="small text-muted text-start">Vetted professionals with years of experience.</p>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-check-circle text-primary me-2"></i>
                                <span class="fw-bold">Ready to Use</span>
                            </div>
                            <p class="small text-muted text-start">Clean code, easy to deploy and customize.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="py-5 bg-light" id="contact">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Talk to the Developers</h2>
                <p class="text-muted">Have questions? We're here to help you choose the right system.</p>
            </div>
            
            <div class="contact-card mx-auto p-4 p-md-5 bg-white shadow-lg border-0" style="max-width: 800px; border-radius: 40px;">
                <form id="contactForm">
                    <div class="row g-4 text-start">
                        <div class="col-md-6">
                            <label class="small fw-bold mb-2">Subject</label>
                            <select name="subject" class="form-select bg-light border-0 py-3 rounded-3 shadow-none">
                                <option>General Inquiry</option>
                                <option>Custom Development</option>
                                <option>Source Code Purchase</option>
                                <option>Thesis Support</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold mb-2">Full Name</label>
                            <input type="text" name="name" class="form-control bg-light border-0 py-3 rounded-3 shadow-none" placeholder="Your name" required>
                        </div>
                        <div class="col-12">
                            <label class="small fw-bold mb-2">Email Address</label>
                            <input type="email" name="email" class="form-control bg-light border-0 py-3 rounded-3 shadow-none" placeholder="Your email for reply" required>
                        </div>
                        <div class="col-12">
                            <label class="small fw-bold mb-2">Message</label>
                            <textarea name="message" class="form-control bg-light border-0 py-3 rounded-3 shadow-none" rows="4" placeholder="How can we help you?" required></textarea>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-lg mt-3">Send Inquiry Now</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Premium Footer -->
    <footer class="footer-dark py-5 mt-5">
        <div class="container pt-5 pb-3">
            <div class="row g-4 mb-5">
                <div class="col-lg-4 text-start">
                    <h3 class="fw-bold text-white mb-4">SINAG <span class="text-primary">IT</span></h3>
                    <p class="text-white-50 pe-lg-5 text-start">Empowering your digital journey with high-performance software and expert development solutions.</p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-6 col-lg-2 text-start">
                    <h6 class="text-white fw-bold mb-4">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="footer-link">Home</a></li>
                        <li class="mb-2"><a href="#catalog" class="footer-link">Catalog</a></li>
                        <li class="mb-2"><a href="#contact" class="footer-link">Inquire</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2 text-start">
                    <h6 class="text-white fw-bold mb-4">Solutions</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="footer-link">E-Commerce</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">School Systems</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Web Apps</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 text-start">
                    <h6 class="text-white fw-bold mb-4">Office Info</h6>
                    <p class="text-white-50 mb-2 text-start"><i class="fas fa-map-marker-alt me-2 text-primary"></i> Quezon City, Philippines</p>
                    <p class="text-white-50 mb-2 text-start"><i class="fas fa-envelope me-2 text-primary"></i> <?= $admin_email ?></p>
                    <p class="text-white-50 text-start"><i class="fas fa-phone-alt me-2 text-primary"></i> +63 9xx xxx xxxx</p>
                </div>
            </div>
            
            <hr class="border-secondary opacity-25">
            
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3">
                <p class="text-white-50 small mb-0">&copy; <?= date('Y') ?> SINAG IT Solutions. Professional Systems Provider.</p>
                <div class="d-flex align-items-center gap-4 mt-3 mt-md-0">
                    <a href="#" class="text-white-50 small text-decoration-none">Privacy Policy</a>
                    <a href="#" class="text-white-50 small text-decoration-none">Terms of Service</a>
                    <a href="auth/login.php" class="text-white-50 opacity-25 hover-opacity-100" title="Staff Access">
                        <i class="fas fa-lock small"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <style>
        .ls-wide { letter-spacing: 2px; }
        .footer-dark { background: #0f172a; color: white; border-radius: 60px 60px 0 0; }
        .footer-link { color: rgba(255,255,255,0.5); text-decoration: none; transition: 0.3s; font-size: 0.9rem; }
        .footer-link:hover { color: #6366f1; padding-left: 5px; }
        .social-btn { width: 40px; height: 40px; background: rgba(255,255,255,0.05); display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; color: white; text-decoration: none; transition: 0.3s; }
        .social-btn:hover { background: #6366f1; transform: translateY(-5px); }
        .hover-opacity-100:hover { opacity: 1 !important; }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Category Filter
            $(".cat-filter").on("click", function() {
                $(".cat-filter").removeClass("active btn-primary").addClass("btn-outline-primary");
                $(this).addClass("active btn-primary").removeClass("btn-outline-primary");
                
                var cat = $(this).data("cat");
                if(cat === "all") {
                    $(".project-item").fadeIn();
                } else {
                    $(".project-item").each(function() {
                        $(this).toggle($(this).data("category") === cat);
                    });
                }
            });

            // Search
            $("#searchInput").on("keyup", function() {
                var v = $(this).val().toLowerCase();
                $(".project-item").each(function() { $(this).toggle($(this).data("title").includes(v) || $(this).data("tech").includes(v)); });
            });

            // Modal Logic
            $(".btn-quickview").on("click", function() {
                const p = $(this).data("project");
                $("#modalTitle").text(p.title); 
                $("#modalDesc").text(p.desc); 
                $("#modalPrice").text(p.price);
                $("#modalDev").text(p.dev);
                $("#modalCategory").text(p.category);
                $("#negNote").text(p.is_neg ? "Negotiable based on requirements." : "Fixed price.");
                
                // Set data attributes for inquiry
                $("#modalInquire").attr("data-id", p.id).attr("data-title", p.title);

                let vHtml = p.video ? `<video class="w-100 h-100" controls autoplay muted><source src="assets/videos/${p.video}" type="video/mp4"></video>` : (p.yt ? `<iframe src="https://www.youtube.com/embed/${p.yt}?autoplay=1" allowfullscreen></iframe>` : "");
                $("#modalVideoContainer").html(vHtml);
                let tHtml = ""; p.tech.split(',').forEach(t => { tHtml += `<span class="badge bg-light text-primary border px-3 py-2 small fw-bold">${t.trim()}</span>`; });
                $("#modalTech").html(tHtml);
                $("#projectModal").modal("show");
            });

            // Handle Contact Form
            $('#contactForm').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                let mailto = `mailto:<?= $admin_email ?>?subject=${$('#inquirySubject').val()}&body=${encodeURIComponent($('[name="message"]').val())}`;
                
                $.post('actions/save_inquiry.php', formData, function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Inquiry Recorded!',
                        text: 'We have saved your inquiry. Opening your email client now...',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = mailto;
                    });
                });
            });

            // Handle Modal Inquire Button
            $('#modalInquire').on('click', function(e) {
                e.preventDefault();
                const title = $(this).data('title');
                const id = $(this).data('id');
                
                Swal.fire({
                    title: 'Inquire about ' + title,
                    html: `
                        <input id="swal-name" class="swal2-input" placeholder="Your Name">
                        <input id="swal-email" class="swal2-input" placeholder="Your Email">
                        <textarea id="swal-msg" class="swal2-textarea" placeholder="Your Message"></textarea>
                    `,
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: 'Send Inquiry',
                    confirmButtonColor: '#6366f1',
                    preConfirm: () => {
                        return {
                            name: document.getElementById('swal-name').value,
                            email: document.getElementById('swal-email').value,
                            message: document.getElementById('swal-msg').value
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const data = result.value;
                        data.subject = "Inquiry: " + title;
                        data.project_id = id;
                        
                        $.post('actions/save_inquiry.php', data, function(res) {
                            Swal.fire('Sent!', 'Your inquiry has been recorded.', 'success').then(() => {
                                window.location.href = `mailto:<?= $admin_email ?>?subject=Inquiry: ${title}&body=${encodeURIComponent(data.message)}`;
                            });
                        });
                    }
                });
            });

            $('#projectModal').on('hidden.bs.modal', function () { $("#modalVideoContainer").html(""); });
        });
    </script>
</body>
</html>
