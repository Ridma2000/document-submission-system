<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Document</title>
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
        .sidebar .nav-link {
            font-size: 18px;
            color: #4a235a;
            padding: 5px;
            margin-bottom: 10px;
        }
        .main-content {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            padding: 20px;
            overflow-y: auto;
            height: calc(100vh - 70px);
        }
        .document-details, .comment-section, .remarks-section {
            width: 100%;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: left;
        }
        .btn {
            padding: 10px 20px;
            font-size: 1rem;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-accept {
            background-color: #4a235a;
        }
        .btn-accept:hover {
            background-color: #4a235a;
        }
        .btn-reject {
            background-color: #dc3545;
        }
        .btn-reject:hover {
            background-color: #c82333;
        }
        .btn-back {
            background-color: #007bff;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
        .download-link {
            font-size: 1rem;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .download-link:hover {
            text-decoration: underline;
        }
        textarea {
            width: 100%;
            height: 100px;
            margin-top: 10px;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .remarks-section {
            margin-top: 20px;
            padding: 15px;
        }
        .remarks-section h2 {
            margin-bottom: 15px;
        }
        .remark {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .remark:last-child {
            border-bottom: none;
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

    <!-- Header -->
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
                <a href="/documents/review" class="nav-link">Documents Review</a>
                <a href="/documents/submit" class="nav-link">Submit Documents</a>
                <a href="/checkStatus" class="nav-link">Check Status</a>
            </nav>

            <!-- Main Content -->
            <main class="col main-content">
                <h2>Review Document</h2>
                <div class="document-details">
                    <p><strong>Submitted By:</strong> <?= $document['UserName'] ?></p>
                    <p><strong>Submitted At:</strong> <?= $document['SubmittedAt'] ?></p>
                    <p><strong>Description:</strong> <?= $document['document_description'] ?></p>
                    <p><strong>File:</strong> 
                        <a href="/<?= $document['FilePath'] ?>" download class="download-link">Download PDF</a>
                    </p>
                </div>

                <!-- Previous Remarks Section -->
                <div class="remarks-section">
                    <h2>Previous Remarks</h2>
                    <?php if (!empty($auditDetails)): ?>
                        <?php foreach ($auditDetails as $audit): ?>
                            <div class="remark">
                                <p><strong>Reviewer:</strong> <?= $audit['reviewer'] ?></p>
                                <p><strong>Date:</strong> <?= $audit['lastUpdatedTime'] ?></p>
                                <p><strong>Decision:</strong> <?= $audit['auditState'] ?></p>
                                <p><strong>Remarks:</strong> <?= !empty($audit['remarks']) ? $audit['remarks'] : 'No remarks provided' ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No previous remarks available.</p>
                    <?php endif; ?>
                </div>

                <!-- Accept, Reject, and Comment Section -->
                <div class="comment-section">
                    <form action="/documents/decision" method="post">
                        <input type="hidden" name="document_id" value="<?= $document['DocumentID'] ?>">

                        <label for="audit_state"><strong>Select Review Decision:</strong></label>
                        <select name="audit_state" id="audit_state" required>
                            <option value="">-- Select --</option>
                            <?php foreach ($auditStates as $state): ?>
                                <option value="<?= $state['AuditStateID'] ?>"><?= $state['AuditState'] ?></option>
                            <?php endforeach; ?>
                        </select>

                        <br><br>
                        <label for="reviewer_comment"><strong>Add a Comment (Optional):</strong></label>
                        <textarea name="reviewer_comment" placeholder="Write your comment here..."></textarea>
                        <br>
                        <button type="submit" class="btn btn-accept">Submit Decision</button>
                    </form>
                </div>

                <a href="/documents/review" class="btn btn-back">Back to Review List</a>
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
    </script>

</body>
</html>