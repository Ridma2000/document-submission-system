<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
        
        .main-content {
            background: white;
            border-radius: 8px;
            padding: 20px;
            height: calc(100vh - 70px);
            overflow-y: auto;
        }
        
        .admin-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .admin-container h1 {
            text-align: center;
            color: #4a235a;
            margin-bottom: 20px;
            font-family: serif;
            font-size: 40px;
        }
        .admin-container .btn {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            font-size: 18px;
            font-family: serif;
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
    </header>

    <!-- Main Layout -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="sidebar">
                <h5 class="mb-4">Admin Menu</h5>
                <a href="/adminPage/addUser" class="nav-link">Add User</a>
                <a href="/adminPage/addDocType" class="nav-link">Add Doc Type</a>
                <a href="/adminPage/editDocType" class="nav-link">Edit Doc Type</a>
                <a href="/adminPage/seeUsers" class="nav-link">See Users</a>
                <a href="auth/logout" class="nav-link text-danger">Logout</a> <!-- Added Logout in Menu -->
            </nav>

            <!-- Main Content -->
            <main class="col main-content">
                <div class="admin-container">
                    <h1>Admin Actions</h1>
                    <button class="btn btn-primary" onclick="navigateTo('/adminPage/addUser')">Add User</button>
                    <button class="btn btn-info" onclick="navigateTo('/adminPage/addDocType')">Add Doc Type</button>
                    <button class="btn btn-warning" onclick="navigateTo('/adminPage/editDocType')">Edit Doc Type</button>
                    <button class="btn btn-success" onclick="navigateTo('/adminPage/seeUsers')">See Users</button>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function navigateTo(url) {
            window.location.href = url;
        }
    </script>
</body>
</html>
