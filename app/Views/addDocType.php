<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Document Type</title>
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
            background-color: transparent;
            color: #4a235a !important;
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
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            font-family: Serif;
        }
        .container h1 {
            text-align: center;
            color: #4a235a;
            margin-bottom: 20px;
            font-family: serif;
            font-size: 40px;
        }
        .form-group {
            margin-bottom: 15px;
            font-family: Serif;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            font-family: Serif;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: Serif;
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
            margin-top: 10px;
            font-family: Serif;
        }
        .btn:hover {
            background-color: #6d3b8a;
        }
        .btn-secondary {
            background-color: #ff4c4c;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #e63939;
        }
        .message {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
            font-family: Serif;
        }
        .selected-users {
            margin-top: 20px;
            text-align: left;
            font-family: Serif;
        }
        .selected-users ul {
            list-style: none;
            padding: 0;
            font-family: Serif;
        }
        .selected-users li {
            background: #f9f9f9;
            padding: 10px;
            border: 1px solid #ccc;
            margin-bottom: 5px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            font-family: Serif;
        }
        .remove-btn {
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            padding: 5px;
            font-family: Serif;
        }
        .remove-btn:hover {
            background: rgb(245, 42, 42);
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
                <a href="/adminPage/addDocType" class="nav-link active">Add Doc Type</a>
                <a href="/adminPage/editDocType" class="nav-link">Edit Doc Type</a>
                <a href="/adminPage/seeUsers" class="nav-link">See Users</a>
                <a href="/auth/logout" class="nav-link text-danger">Logout</a> <!-- Added Logout in Menu -->
            </nav>

            <!-- Main Content -->
            <main class="col main-content">
                <div class="container">
                    <h1>Add Document Type</h1>
                    <form action="/adminPage/saveDocType" method="POST">
                        <div class="form-group">
                            <label for="DocTypeName">Document Type Name</label>
                            <input type="text" id="DocTypeName" name="DocTypeName" placeholder="Enter Document Type" required>
                        </div>
                        <div class="form-group">
                            <label for="Description">Document Description</label>
                            <textarea id="Description" name="Description" placeholder="Enter Document Description" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="userType">Select User Type</label>
                            <select id="userType" name="userType" required>
                                <option value="" disabled selected>Select User Type</option>
                                <?php foreach ($userTypesWithAffiliations as $userType): ?>
                                    <option value="<?= $userType['UserTypeID'] ?>">
                                        <?= $userType['UserTypeName'] ?> - <?= $userType['AffiliationName'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="selected-users">
                            <strong>Approval Order:</strong>
                            <ul id="approvalOrder"></ul>
                        </div>

                        <!-- Hidden input to store selected user order -->
                        <input type="hidden" name="selectedUsers" id="selectedUsers">
                        
                        <button type="submit" class="btn">Save</button>
                    </form>
                    <a href="<?= site_url('adminPage') ?>" class="btn btn-secondary">Go to Admin Page</a>

                    <?php if (isset($message)): ?>
                        <div class="message"><?= esc($message) ?></div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const userTypeSelect = document.getElementById('userType');
        const approvalOrderList = document.getElementById('approvalOrder');
        const selectedUsersInput = document.getElementById('selectedUsers');

        let selectedUsers = [];

        userTypeSelect.addEventListener('change', () => {
            const selectedOption = userTypeSelect.options[userTypeSelect.selectedIndex];
            const userId = selectedOption.value;
            const userName = selectedOption.text;

            // Prevent duplicates
            if (selectedUsers.some(user => user.id === userId)) {
                alert('User already added!');
                return;
            }

            // Add the selected user to the list
            selectedUsers.push({ id: userId, name: userName });
            updateApprovalOrder();
        });

        function updateApprovalOrder() {
            approvalOrderList.innerHTML = '';
            selectedUsers.forEach((user, index) => {
                const listItem = document.createElement('li');
                listItem.innerHTML = `
                    ${index + 1}. ${user.name}
                    <button class="remove-btn" onclick="removeUser('${user.id}')">Remove</button>
                `;
                approvalOrderList.appendChild(listItem);
            });

            // Update hidden input value
            selectedUsersInput.value = JSON.stringify(selectedUsers.map(user => user.id));
        }

        function removeUser(userId) {
            selectedUsers = selectedUsers.filter(user => user.id !== userId);
            updateApprovalOrder();
        }
    </script>
</body>
</html>
