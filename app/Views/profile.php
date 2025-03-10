<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
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
        .profile-container {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 600px;
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
                <div class="profile-container">
                    <h2 class="text-center">My Profile</h2>
                    <p><strong>Name:</strong> <?= esc($user['NameWithInitial']) ?></p>
                    <p><strong>Contact Number:</strong> <?= esc($user['contact_number']) ?></p>
                    <p><strong>Designation:</strong> <?= esc($user['designation']) ?></p>
                    <p><strong>Email:</strong> <?= esc($user['email']) ?></p>
                    <a href="/editProfile" class="btn">Edit Profile</a>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
