<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Document Type</title>
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
            font-family: Serif;
            color: #fff;
            
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
            font-family: Serif;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 90%;
            max-width: 700px;
            font-family: Serif;
        }
        h1 {
            color: #333;
            margin-bottom: 15px;
            font-family: Serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            font-family: Serif;
        }
        th, td {
            padding: 12px;
            text-align: left;
            font-family: Serif;
        }
        th {
            background: linear-gradient(to right,  #6d3b8a,  #6d3b8a);
            color: white;
            font-size: 16px;
            font-family: Serif;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
            font-family: Serif;
        }
        tr:hover {
            background-color: #f1f1f1;
            font-family: Serif;
        }
        ol {
            padding-left: 20px;
            margin: 0;
            font-family: Serif;
        }
        .delete-btn {
            background:rgb(245, 42, 42);
            color: white;
            border: none;
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }
        .delete-btn:hover {
            background: #cc0000;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 18px;
            background: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-size: 16px;
            transition: 0.3s;
        }
        .back-link:hover {
            background:  #6d3b8a;
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
                <a href="/auth/logout" class="nav-link text-danger">Logout</a> <!-- Added Logout in Menu -->
            </nav>

            <!-- Main Content -->
            <main class="col main-content">
                <div class="container">
                    <h1>Edit Document Type</h1>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>Document Type</th>
                                <th>Approval Hierarchy</th>
                                <!-- <th>Actions</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($docTypes as $docType): ?>
                                <tr>
                                    <td><strong><?= esc($docType['DocTypeName']) ?></strong></td>
                                    <td>
                                        <?php if (!empty($docHierarchy[$docType['DocTypeID']])): ?>
                                            <ol>
                                                <?php foreach ($docHierarchy[$docType['DocTypeID']] as $hierarchy): ?>
                                                    <li>
                                                        <?= esc($hierarchy['UserTypeName']) ?> 
                                                    </li>
                                                <?php endforeach; ?>
                                            </ol>
                                        <?php else: ?>
                                            <span style="color: #888;">No hierarchy assigned</span>
                                        <?php endif; ?>
                                    </td>

      
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <a href="/adminPage" class="back-link">Back to Admin Page</a>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
