<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Page</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background:  #f8f9fa;
            background-size: cover;
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
            font-family: serif;
        }
        .header img {
            height: 40px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0;
            font-family: serif;
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
            font-family: serif;
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
            <nav class="sidebar">
                <h5 class="mb-4">Dashboard</h5>
                <a href="/documents/review" class="nav-link">Documents Review</a>
                <a href="/documents/submit" class="nav-link">Submit Documents</a>
                <a href="/checkStatus" class="nav-link">Check Status</a>
            </nav>
            <main class="col main-content" id="content">
                <h2>We're Here to Help You!</h2>
                <p class="lead">Providing 24/7 support for all your needs. Contact us anytime.</p>

                <!-- Support Details -->
                <div class="glass-card mt-4 p-4">
                    <h3>📞 Contact Information</h3>
                    <p><strong>Email:</strong> <a href="mailto:support@creativesolutions.com" class="text-primary">support@creativesolutions.com</a></p>
                    <p><strong>Phone:</strong> <a href="tel:+94713454048" class="text-primary">+94 71 345 4048</a></p>
                    <p><strong>Live Support:</strong> Available Monday to Friday, 9 AM - 6 PM</p>
                </div>

                <!-- Testimonials -->
                <div class="glass-card mt-4 p-4">
                    <h3>🌟 What Our Customers Say</h3>
                    <div class="testimonial">
                        "Excellent support! They resolved my issue in no time. Highly recommended!" - Sarah D.
                    </div>
                    <div class="testimonial">
                        "The team was very helpful and patient. Great service!" - James T.
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="glass-card mt-4 p-4">
                    <h3>❓ Frequently Asked Questions (FAQs)</h3>
                    <p><strong>🔹 How long does it take for support to respond?</strong><br> We usually reply within 24 hours.</p>
                    <p><strong>🔹 Can I get phone support?</strong><br> Yes! You can call us at +94 71 345 4048 during business hours.</p>
                    <p><strong>🔹 What if I don’t receive a reply?</strong><br> Please check your spam folder or try contacting us via phone.</p>
                </div>
            </main>
        </div>
    </div>

    <!-- Live Chat Button -->
    <div class="chat-box" onclick="alert('Live chat is currently unavailable. Please use the contact details above.')">
        💬 Live Chat
    </div>

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