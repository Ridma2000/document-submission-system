<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: serif;
            margin: 0;
            padding: 0;
            height: 100vh;
        }
        .header {
            background: #4a235a;
            color: white;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header img {
            height: 40px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0;
            font-weight: bold;
        }
        .sidebar {
            background: #f8f9fa;
            min-height: calc(100vh - 70px);
            padding: 15px;
            width: 200px;
        }
        .sidebar .nav-link {
            font-size: 18px;
            margin-bottom: 10px;
            color: #4a235a;
            padding: 5px;
        }
        .main-content {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            padding: 20px;
            height: calc(100vh - 70px);
            overflow-y: auto;
        }
        .form-container {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            margin: auto;
        }
        .btn {
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 10px;
            background-color: #4a235a;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #36144d;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        .message {
            color: green;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="d-flex align-items-center">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="University Logo">
            <h1 class="ms-3">Document Submission System<br><small>University of Colombo</small></h1>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav class="sidebar">
                <h5 class="mb-4">Dashboard</h5>
                <a href="/documents/review" class="nav-link">Documents Review</a>
                <a href="/documents/submit" class="nav-link">Submit Documents</a>
                <a href="/checkStatus" class="nav-link">Check Status</a>
            </nav>
            <main class="col main-content">
                <div class="form-container">
                    <h2 class="text-center">Edit Profile</h2>
                    <!-- Display flash messages -->
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="error">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('message')) : ?>
                        <div class="message">
                            <?= session()->getFlashdata('message') ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="/editProfile">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?= esc($user['contact_number']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="designation" class="form-label">Designation</label>
                            <input type="text" class="form-control" id="designation" name="designation" value="<?= esc($user['designation']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn">Save</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
