<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>See Users</title>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <style>
        /* Global Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: rgba(255, 255, 255, 0.9);
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
            padding-left: 100px;
            padding-top: 30px;
        }

        /* Container Styling */
        .container {
            width: 100%;
            max-width: 1000px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: fadeIn 1s ease-in-out;
            font-family: serif;
            color:#6d3b8a;
            
        }

        h1 {
            font-weight: 600;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            font-family: serif;
        }

        /* DataTables Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            overflow: hidden;
            color: #333;
            font-family: serif;
        }

        th {
            background: #6d3b8a;;
            color: white;
            padding: 12px;
            font-family: serif;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            font-family: serif;
        }

        tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.7);
            font-family: serif;
        }

        tr:nth-child(odd) {
            background: rgba(255, 255, 255, 0.5);
            font-family: serif;
        }

        /* Dropdown Styling */
        .status-dropdown {
            padding: 5px;
            border-radius: 5px;
            cursor: pointer;
            font-family: serif;
        }

        /* Fade In Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1><i class="fas fa-users"></i> List of Users</h1>
        <table id="usersTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Last Name</th>
                    <th>Role</th>
                    <th>Contact</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <button class="back-btn" onclick="goBack()"><i class="fas fa-arrow-left"></i> Back</button>
    </div>

    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                "ajax": "/adminPage/getUsers",
                "columns": [
                    { "data": "id" },
                    { "data": "UserName" },
                    { "data": "email" },
                    { "data": "name" },
                    { "data": "LastName" },
                    { "data": "Role" },
                    { "data": "contact_number" },
                    { 
                        "data": "status",
                        "render": function(data, type, row) {
                            return `<select class="status-dropdown" data-id="${row.id}">
                                        <option value="Active" ${data === "Active" ? "selected" : ""}>Active</option>
                                        <option value="Deactive" ${data === "Deactive" ? "selected" : ""}>Deactive</option>
                                    </select>`;
                        }
                    }
                ],
                "paging": true,
                "ordering": true,
                "info": true
            });

            // Change status event
            $(document).on('change', '.status-dropdown', function() {
                var userId = $(this).data('id');
                var newStatus = $(this).val();

                $.ajax({
                    url: '/adminPage/updateUserStatus',
                    method: 'POST',
                    data: { id: userId, status: newStatus },
                    success: function(response) {
                        alert(response.message);
                    },
                    error: function(xhr) {
                        alert('Error updating status');
                    }
                });
            });
        });

        function goBack() {
            window.location.href = "/adminPage"; 
        }
    </script>

</body>
</html>
