<?php
require_once 'sidebar.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/styles.css"> <!-- Adjust path if necessary -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* General Reset */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            background-color: #f4f6f9;
        }

    

        /* Content Area */
        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
            background-color: #f4f6f9;
        }

        .dashboard-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #1565c0;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }
    </style>
</head>
<body>
   

    <!-- Content Area -->
    <div class="content">
        <div class="dashboard-container">
            <h2>Welcome to the Dashboard</h2>
            <p>
                This is the main dashboard of your system. From here, you can navigate to various sections:
            </p>
            <ul>
                <li><strong>Manage Staff</strong>: Add, update, or delete staff records.</li>
                <li><strong>Manage Equipment</strong>: Add new equipment, update their details, or remove them.</li>
                <li><strong>View Reports</strong>: Access system performance and usage reports (future feature).</li>
            </ul>
        </div>
    </div>
</body>
</html>
