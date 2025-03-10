<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Document</title>
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
            font-family: serif;
            
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
            padding: 5px;
        }
        .table-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .table-container h1 {
            text-align: center;
            color: #4a235a;
            margin-bottom: 20px;
            font-family: serif;
            font-size: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #f9f9f9;
            font-family: serif;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
            font-family: serif;
        }
        th {
            background: #4a235a;
            color: white;
            font-family: serif;
        }
        .btn-primary {
            background-color: #4a235a;
            border: none;
            font-family: serif;
        }
        .btn-primary:hover {
            background-color: #3a1b4a;
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
                <div class="table-container">
                    <h1>Document Details</h1>
                    <table>
                        <tr>
                            <th>Document ID</th>
                            <td><?= esc($document['DocumentID']) ?></td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td><?= esc($document['document_description']) ?></td>
                        </tr>
                        <tr>
                            <th>Submitted At</th>
                            <td><?= esc($document['SubmittedAt']) ?></td>
                        </tr>
                    </table>

                    <h1>Audit Details</h1>
                    <table>
                        <tr>
                            <th>Reviewer</th>
                            <th>Last Updated Time</th>
                            <th>Audit State</th>
                            <th>Remarks</th>
                        </tr>
                        <?php if (!empty($auditDetails)): ?>
                            <?php foreach ($auditDetails as $audit): ?>
                                <tr>
                                    <td><?= esc($audit['reviewer']) ?></td>
                                    <td><?= esc($audit['lastUpdatedTime']) ?></td>
                                    <td><?= esc($audit['auditState']) ?></td>
                                    <td><?= esc($audit['remarks']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center;">No review history available</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                    <a href="/checkStatus" class="btn btn-primary mt-3">Back to Status</a>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
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
    </script></body>
</html>