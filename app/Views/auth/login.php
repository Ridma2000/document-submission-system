<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Faculty of Science</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Inline CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: serif; /* Changed to generic serif font */
        }
        .card {
            border-radius: 12px;
            border: none;
        }
        .card h4, .card h5 {
            color: #4a235a;
            font-family: serif; /* Ensures headers use serif font */
        }
        .btn-primary {
            background-color: #4a235a;
            border-color: #4a235a;
            font-family: serif; /* Serif font for button text */
        }
        .btn-primary:hover {
            background-color: #6d3b8a;
            border-color: #6d3b8a;
        }
        .form-label {
            font-weight: bold;
            color: #4a235a;
            font-family: serif; /* Serif font for form labels */
        }
        a.text-decoration-none {
            color: #4a235a;
            font-family: serif; /* Serif font for links */
        }
        a.text-decoration-none:hover {
            text-decoration: underline;
            color: #6d3b8a;
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px;">
            <div class="text-center mb-4">
                <img src="<?= base_url('assets/images/faculty-logo.png') ?>" alt="Faculty Logo" style="max-width: 150px;">
                <h5 class="text-uppercase fw-bold">Document Submission System</h5>
                <h5 class="fw-light">University of Colombo</h5>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div style="color: red; margin-bottom: 15px;">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="/auth/loginSubmit" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Log in</button>
                <div class="text-center mt-3">
                </div>
            </form>

            <hr>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
