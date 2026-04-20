<?php
// admin/upload-project.php
require_once '../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Project | SINAG IT</title>
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
                <h2 class="fw-bold m-0">Publish New Project</h2>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="clean-card shadow-sm border-0">
                        <div class="p-4 border-bottom"><h5 class="fw-bold mb-0">Project Information</h5></div>
                        <div class="p-4 p-md-5">
                            <form id="uploadForm" enctype="multipart/form-data">
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <label class="form-label small fw-bold">Project Title</label>
                                        <input type="text" name="title" id="pTitle" class="form-control bg-light border-0 py-3" placeholder="e.g. Pharmacy Management System" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label small fw-bold">Detailed Description</label>
                                        <textarea name="description" id="pDesc" class="form-control bg-light border-0 py-3" rows="5" placeholder="Describe the system features and purpose..." required></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold">Tech Stack</label>
                                        <input type="text" name="tech_stack" class="form-control bg-light border-0 py-3" placeholder="e.g. PHP, MySQL, Bootstrap..." required id="techStackInput">
                                        <div class="mt-2 d-flex flex-wrap gap-2" id="techQuickTags">
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
                                        <input list="categoryOptions" name="category" class="form-control bg-light border-0 py-3" placeholder="Select or type custom category..." required>
                                        <datalist id="categoryOptions">
                                            <option value="Inventory Systems">
                                            <option value="School Management">
                                            <option value="E-Commerce / Retail">
                                            <option value="Custom Web Apps">
                                            <option value="Mobile Applications">
                                            <option value="Desktop Software">
                                        </datalist>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Price (PHP)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0 fw-bold">₱</span>
                                            <input type="number" name="price" id="pPrice" class="form-control bg-light border-0 py-3" placeholder="0.00">
                                        </div>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" name="is_negotiable" id="isNegotiable" value="1">
                                            <label class="form-check-label small text-muted" for="isNegotiable">Mark as Negotiable / Inquire for Price</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Demo Video (MP4)</label>
                                        <input type="file" name="video_file" class="form-control bg-light border-0 py-3" accept="video/mp4">
                                        <div class="small text-muted mt-1">Maximum 40MB. For larger files, use YouTube ID.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">YouTube ID (Optional)</label>
                                        <input type="text" name="youtube_id" class="form-control bg-light border-0 py-3" placeholder="e.g. dQw4w9WgXcQ">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Promotional Badge</label>
                                        <select name="badge" class="form-select bg-light border-0 py-3">
                                            <option value="">None</option>
                                            <option value="NEW">NEW</option>
                                            <option value="HOT">HOT</option>
                                            <option value="TOP SELLER">TOP SELLER</option>
                                        </select>
                                    </div>
                                    <div class="col-12 pt-4">
                                        <div class="progress d-none mb-3" style="height: 10px; border-radius: 5px;">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                        </div>
                                        <button type="submit" id="submitBtn" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-lg">
                                            Publish Project <i class="fas fa-paper-plane ms-2"></i>
                                        </button>
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
$(document).ready(function() {
    // Smart Tech Suggest
    const techMap = {
        'php': 'PHP', 'mysql': 'MySQL', 'database': 'MySQL', 'sql': 'MySQL',
        'bootstrap': 'Bootstrap 5', 'css': 'CSS3', 'html': 'HTML5',
        'javascript': 'JavaScript', 'js': 'JavaScript', 'ajax': 'AJAX',
        'laravel': 'Laravel', 'react': 'React.js', 'vue': 'Vue.js'
    };

    $('#pDesc').on('input', function() {
        const text = $(this).val().toLowerCase();
        let suggestions = [];
        for (let key in techMap) {
            if (text.includes(key) && !suggestions.includes(techMap[key])) suggestions.push(techMap[key]);
        }
        
        let html = suggestions.map(s => `<span class="badge bg-primary-subtle text-primary border px-3 py-2 cursor-pointer tech-chip" style="cursor:pointer">${s}</span>`).join('');
        $('#techSuggestions').html(html);
    });

    $(document).on('click', '.tech-chip', function() {
        let val = $('#pTech').val();
        let tech = $(this).text();
        if (!val.includes(tech)) {
            $('#pTech').val(val ? val + ', ' + tech : tech);
        }
        $(this).fadeOut();
    });

    // Quick Tag Selection
    $('.tag-btn').on('click', function() {
        let tag = $(this).text();
        let currentVal = $('#techStackInput').val();
        if(currentVal === '') {
            $('#techStackInput').val(tag);
        } else {
            if(!currentVal.includes(tag)) {
                $('#techStackInput').val(currentVal + ', ' + tag);
            }
        }
        $(this).removeClass('bg-light').addClass('bg-primary text-white');
    });

    $('#isNegotiable').on('change', function() {
        if ($(this).is(':checked')) {
            $('#pPrice').val('0').prop('readonly', true);
        } else {
            $('#pPrice').prop('readonly', false);
        }
    });

    $('#uploadForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let submitBtn = $('#submitBtn');
        let progressBar = $('.progress');
        let bar = $('.progress-bar');

        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i> Publishing...');
        progressBar.removeClass('d-none');

        $.ajax({
            url: 'actions/upload_process.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = (evt.loaded / evt.total) * 100;
                        bar.css('width', percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'Great Job!', text: res.message, confirmButtonColor: '#6366f1' })
                    .then(() => location.href = 'dashboard.php');
                } else {
                    Swal.fire({ icon: 'error', title: 'Oops!', text: res.message, confirmButtonColor: '#6366f1' });
                    submitBtn.prop('disabled', false).html('Publish Project <i class="fas fa-paper-plane ms-2"></i>');
                    progressBar.addClass('d-none');
                }
            },
            error: function(xhr, status, error) {
                let msg = "Status: " + xhr.status + " (" + error + ")";
                Swal.fire({ icon: 'error', title: 'Upload Failed', text: msg, confirmButtonColor: '#6366f1' });
                submitBtn.prop('disabled', false).html('Publish Project <i class="fas fa-paper-plane ms-2"></i>');
                progressBar.addClass('d-none');
            }
        });
    });
});
</script>
</body>
</html>
