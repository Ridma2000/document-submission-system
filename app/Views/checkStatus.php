<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Document Status</title>
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
        .document-item {
            background: #f1f1f1;
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .status-highlight {
            font-weight: bold;
            color:rgb(136, 24, 24);
        }
        .btn-primary {
            background-color: #4a235a;
        }
        .btn-primary:hover {
            background-color: #4a235a;
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
    
    <div class="container-fluid">
        <div class="row">
            <nav class="sidebar">
                <h5 class="mb-4">Dashboard</h5>
                <a href="/documents/review" class="nav-link">Documents Review</a>
                <a href="/documents/submit" class="nav-link">Submit Documents</a>
                <a href="/checkStatus" class="nav-link">Check Status</a>
            </nav>
            <main class="col main-content">
                <h2>Your Documents</h2>
                
                <?php if(session()->getFlashdata('success')): ?>
                    <p style="color: green;"><?php echo session()->getFlashdata('success'); ?></p>
                <?php elseif(session()->getFlashdata('error')): ?>
                    <p style="color: red;"><?php echo session()->getFlashdata('error'); ?></p>
                <?php endif; ?>
                
                <ul class="list-unstyled">
                    <?php if (!empty($documents)): ?>
                        <?php foreach ($documents as $doc): ?>
                            <li class="document-item">
                                <p>
                                    <?= esc($doc['document_description']) ?> - 
                                    <strong class="status-highlight">Status:</strong> 
                                    <span class="status-highlight">
                                        <?php
                                            $documentStateModel = new \App\Models\DocumentStateModel();
                                            $status = $documentStateModel->find($doc['DocumentStatusID']);
                                            echo $status ? esc($status['DocumentStatus']) : 'Unknown';
                                        ?>
                                    </span>
                                </p>
                                <a href="/documents/view/<?= $doc['DocumentID'] ?>" class="btn btn-primary">View</a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="text-align: center;">No documents assigned to you.</p>
                    <?php endif; ?>
                </ul>
                
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