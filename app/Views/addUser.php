<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
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
            font-family: serif;
        }

        .container {
            width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-family: serif;
        }
        .container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #4a235a;
            font-family: serif;
            font-size: 30px;
            font-family: serif;
        }
        .form-group {
            margin-bottom: 15px;
            font-family: serif;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            font-family: serif;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: serif;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #6d3b8a;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            font-family: serif;
        }
        .btn:hover {
            background-color: #6d3b8a;
        }
        .message {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
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

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="sidebar">
                <h5 class="mb-4">Admin Menu</h5>
                <a href="/adminPage/addUser" class="nav-link active">Add User</a>
                <a href="/adminPage/addDocType" class="nav-link">Add Doc Type</a>
                <a href="/adminPage/editDocType" class="nav-link">Edit Doc Type</a>
                <a href="/adminPage/seeUsers" class="nav-link">See Users</a>
                <a href="/auth/logout" class="nav-link text-danger">Logout</a>
            </nav>

            <!-- Main Content -->
            <main class="col main-content">
                <div class="container">
                    <h1>Add User</h1>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="message" style="color: red;"><?= esc(session()->getFlashdata('error')) ?></div>
                    <?php endif; ?>
                    <form method="post" action="<?= site_url('user/save') ?>">
                        <div class="form-group">
                            <label for="username">User Name</label>
                            <input type="text" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="affiliation">Affiliation</label>
                            <select id="affiliation" name="affiliation" required>
                                <option value="">Select Affiliation</option>
                                <?php if (!empty($affiliations)): ?>
                                    <?php foreach ($affiliations as $affiliation): ?>
                                        <option value="<?= esc($affiliation['AffiliationID']) ?>">
                                            <?= esc($affiliation['AffiliationName']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="" disabled>No Affiliations Available</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="userTypesId">User Types ID</label>
                            <select id="userTypesId" name="userTypesId" required>
                                <option value="">Select User Type</option>
                                <?php foreach ($userTypes as $userType): ?>
                                    <option value="<?= esc($userType['UserTypeID']) ?>"><?= esc($userType['UserTypeName']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nameWithInitial">Name with Initial</label>
                            <input type="text" id="nameWithInitial" name="nameWithInitial" required>
                        </div>
                        <div class="form-group">
                            <label for="name">First Name</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" id="lastName" name="lastName" required>
                        </div>
                        <div class="form-group">
                            <label for="designation">Designation</label>
                            <input type="text" id="designation" name="designation" required>
                        </div>
                        <div class="form-group">
                            <label for="streetAddress">Street Address</label>
                            <input type="text" id="streetAddress" name="streetAddress" required>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" required>
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" id="state" name="state" required>
                        </div>
                        <div class="form-group">
                            <label for="postalCode">Postal Code</label>
                            <input type="text" id="postalCode" name="postalCode" required>
                        </div>
                        <div class="form-group">
                            <label for="contactNumber">Contact Number</label>
                            <input type="text" id="contactNumber" name="contactNumber" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select id="role" name="role" required>
                                <option value="">Select Role</option>
                                <option value="Admin">Admin</option>
                                <option value="User">User</option>
                            </select>
                        </div>
                        <button type="submit" class="btn">Add User</button>
                    </form>
                    <?php if (isset($message)): ?>
                        <div class="message"><?= esc($message) ?></div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
