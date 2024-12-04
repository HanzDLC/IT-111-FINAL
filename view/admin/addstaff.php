<?php
require_once '../../controller/UserController.php';

$userController = new UserController();

// Handle form submission to add staff
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isAdded = $userController->handleAddStaff($_POST);
    if ($isAdded) {
        echo "<p style='color: green;'>Staff added successfully!</p>";
    } else {
        echo "<p style='color: red;'>Failed to add staff. Try again.</p>";
    }
}

// Handle deletion of staff
if (isset($_GET['delete'])) {
    $staffId = $_GET['delete'];
    $isDeleted = $userController->handleDeleteStaff($staffId); // Delete staff
    if ($isDeleted) {
        echo "<p style='color: green;'>Staff deleted successfully!</p>";
    } else {
        echo "<p style='color: red;'>Failed to delete staff. Try again.</p>";
    }
}


$staffList = $userController->getAllStaff();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Staff</title>
    <link rel="stylesheet" href="../assets/styles.css"> <!-- Adjusted path -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: row; /* Aligns the sidebar and main content horizontally */
        }

        .main-content {
            margin-left: 270px; /* Adjust to the width of the sidebar */
            padding: 20px;
            width: calc(100% - 270px);
        }

        .staff-container {
            width: 90%;
            max-width: 800px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #1565c0;
            margin-bottom: 20px;
        }

        .staff-form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-size: 14px;
            color: #0d47a1;
            margin-bottom: 5px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #90caf9;
            border-radius: 5px;
            font-size: 14px;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #42a5f5;
            box-shadow: 0px 0px 5px rgba(66, 165, 245, 0.8);
        }

        button {
            background-color: #1565c0;
            color: #ffffff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #0d47a1;
        }

        .staff-list-container {
            max-height: 400px; /* Adjust height as needed */
            overflow-y: auto; /* Enable vertical scrolling */
            border: 1px solid #ddd; /* Optional: Adds a border for clarity */
            border-radius: 8px; /* Optional: For visual consistency */
            margin-top: 20px;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            font-size: 14px;
        }

        table th {
            background-color: #1565c0;
            color: white;
            position: sticky;
            top: 0; /* Keeps the header sticky while scrolling */
            z-index: 1;
        }

        table tr:nth-child(even) {
            background-color: #f1f8e9;
        }

        .table-container {
            width: 100%;
        }

        .btn {
            background-color: #ADE8F4;
            color: #ffffff;
            border: none;
            padding: 5px 10px;
            border-radius: 10px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .btn:hover {
            background-color: #0d47a1;
        }

        /* Responsive Design for Smaller Screens */
        @media (max-width: 768px) {
            body {
                flex-direction: column; /* Stacks sidebar and main content vertically */
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Include Sidebar -->
    <?php require_once 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="staff-container">
            <h2>Add Staff</h2>
            <form action="addStaff.php" method="POST">
                <div class="staff-form-group">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" name="first-name" placeholder="Enter First Name" required>
                </div>
                <div class="staff-form-group">
                    <label for="last-name">Last Name</label>
                    <input type="text" id="last-name" name="last-name" placeholder="Enter Last Name" required>
                </div>
                <div class="staff-form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter Email" required>
                </div>
                <div class="staff-form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter Password" required>
                </div>
                <div class="staff-form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" placeholder="Enter Phone Number" required>
                </div>
                <div class="staff-form-group">
                    <label for="specialty">Specialty</label>
                    <input type="text" id="specialty" name="specialty" placeholder="Specialty (e.g., Photographer)" required>
                </div>
            
                <button type="submit">Add Staff</button>
            </form>
        </div>

        <div class="staff-container staff-list-container">
            <h2>Registered Staff</h2>
            <table>
                <thead>
                    <tr>
                        <th>Staff ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Specialty</th>
                        <th>Registered Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($staffList)) : ?>
                        <?php foreach ($staffList as $staff) : ?>
                            <tr>
                                <td><?= htmlspecialchars($staff['staff_id']) ?></td>
                                <td><?= htmlspecialchars($staff['fname']) ?></td>
                                <td><?= htmlspecialchars($staff['lname']) ?></td>
                                <td><?= htmlspecialchars($staff['email']) ?></td>
                                <td><?= htmlspecialchars($staff['phone']) ?></td>
                                <td><?= htmlspecialchars($staff['specialty']) ?></td>
                                <td><?= htmlspecialchars($staff['registered_date']) ?></td>
                                <td>
                                    <a href="editStaff.php?edit=<?= htmlspecialchars($staff['staff_id']) ?>">
                                        <button class="btn">Edit</button>
                                    </a>
                                    <a href="addStaff.php?delete=<?= htmlspecialchars($staff['staff_id']) ?>">
                                        <button class="btn">Delete</button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="8">No staff registered yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
