<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Documents</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: Arial, sans-serif;
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
            font-family: Serif;
        }
        .header img {
            height: 40px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0;
        }
        .sidebar {
            background: #f8f9fa;
            min-height: calc(100vh - 70px);
            padding: 15px;
            width: 200px;
        }
        .sidebar h5 {
            color: #4a235a;
            font-weight: bold;
            font-family: Serif;
        }
        .sidebar .nav-link {
            font-size: 18px;
            margin-bottom: 10px;
            color: #4a235a;
            font-family: Serif;
            padding: 5px;
        }
        .sidebar .nav-link:hover {
            color: #4a235a;
        }
        .sidebar .nav-link.active {
            background-color: #4a235a;
            color: white !important;
            border-radius: 5px;
        }
        .main-content {
            background: white;
            border-radius: 8px;
            padding: 20px;
            height: calc(100vh - 70px);
            overflow-y: auto;
            font-family: serif;
        }
        .profile-container {
            position: relative;
            cursor: pointer;
        }
        .profile-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            min-width: 150px;
            z-index: 1000;
        }
        .profile-dropdown a {
            display: block;
            padding: 10px;
            color: #333;
            text-decoration: none;
            font-family: serif;
        }
        .profile-dropdown a:hover {
            background-color: #f3f4f6;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-family: serif;
        }
        .form-container h1 {
            text-align: center;
            color: #4a235a;
            margin-bottom: 20px;
            font-family: serif;
            font-size: 40px;
        }
        .form-container label {
            font-weight: bold;
            font-family: serif;
        }
        .form-container .btn {
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
        .form-container .btn:hover {
            background-color: #36144d;
        }
        
    </style>
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <div class="d-flex align-items-center">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="University Logo">
            <h1 class="ms-3">Document Submission System<br><small>University of Colombo</small></h1>
        </div>
        <div class="profile-container" onclick="toggleDropdown()">
            <img src="<?= base_url('assets/images/user-profile.jpg') ?>" alt="Profile Picture" style="height: 30px; width: 30px; border-radius: 50%;">
            <div class="profile-dropdown" id="profileDropdown">
                <span class="d-block px-3 py-2 text-dark"><strong><?= session()->get('user_email') ?></strong></span>
                <a href="/profile">My Profile</a>
                <a href="/support">Support</a>
                <a href="/auth/logout">Logout</a>
            </div>
        </div>
    </header>

    <!-- Main Layout -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="sidebar">
                <h5 class="mb-4">Dashboard</h5>
                <a href="/documents/review" class="nav-link <?= (current_url() == base_url('/documents/review')) ? 'active' : '' ?>">Documents Review</a>
                <a href="/documents/submit" class="nav-link <?= (current_url() == base_url('/documents/submit')) ? 'active' : '' ?>">Submit Documents</a>
                <a href="/checkStatus" class="nav-link <?= (current_url() == base_url('/checkStatus')) ? 'active' : '' ?>">Check Status</a>
            </nav>

            <!-- Main Content -->
            <main class="col main-content">
                <div class="form-container">
                    <h1>Submit Documents</h1>
                    <form action="<?= site_url('documents/upload') ?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="document_type" class="form-label">Document Type:</label>
                            <select name="document_type" id="document_type" class="form-select" required>
                                <option value="" disabled selected>Select Document Type</option>
                                <?php foreach ($documentTypes as $type): ?>
                                    <option value="<?= $type['DocTypeID']; ?>"><?= esc($type['DocTypeName']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="document_description" class="form-label">Document Description:</label>
                            <textarea name="document_description" id="document_description" class="form-control" placeholder="Enter Document Description" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="document" class="form-label">Choose Document:</label>
                            <input type="file" name="document" id="document" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById('profileDropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }
        document.addEventListener('click', function(event) {
            var profileContainer = document.querySelector('.profile-container');
            var dropdown = document.getElementById('profileDropdown');
            if (!profileContainer.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        });
    </script>
</body>
</html>