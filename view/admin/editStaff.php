<?php
require_once '../../controller/UserController.php';

$userController = new UserController();

// Fetch the staff member to be edited (if the 'edit' parameter is passed)
if (isset($_GET['edit'])) {
    $staffId = $_GET['edit'];
    $staff = $userController->getStaffById($staffId); // Fetch staff by ID
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission to update staff
    $isUpdated = $userController->handleUpdateStaff($_POST); // Pass $_POST directly to handleUpdateStaff
    if ($isUpdated) {
        echo "<p style='color: green;'>Staff updated successfully!</p>";
    } else {
        echo "<p style='color: red;'>Failed to update staff. Try again.</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Staff</title>
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
        }

        .staff-container {
            width: 90%;
            max-width: 1000px;
            margin: 30px auto;
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

        .btn {
            background-color: #ff7043;
            color: #ffffff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px; /* Space between buttons */
            margin-bottom: 5px;
        }

        .btn:hover {
            background-color: #d32f2f;
        }

        /* Improve table responsiveness */
        @media (max-width: 768px) {
            table th, table td {
                font-size: 12px;
                padding: 8px;
            }

            button {
                font-size: 14px;
            }

            .staff-container {
                width: 95%;
            }
        }
    </style>
</head>
<body>
    <div class="staff-container">
        <h2>Edit Staff</h2>
        <form action="editStaff.php?edit=<?= htmlspecialchars($staff['staff_id']) ?>" method="POST">
            <!-- Hidden input field for staff_id to pass it via POST -->
            <input type="hidden" name="staff_id" value="<?= htmlspecialchars($staff['staff_id']) ?>">

            <div class="staff-form-group">
                <label for="first-name">First Name</label>
                <input type="text" id="first-name" name="first-name" value="<?= htmlspecialchars($staff['fname']) ?>" required>
            </div>
            <div class="staff-form-group">
                <label for="last-name">Last Name</label>
                <input type="text" id="last-name" name="last-name" value="<?= htmlspecialchars($staff['lname']) ?>" required>
            </div>
            <div class="staff-form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($staff['email']) ?>" required>
            </div>
            <div class="staff-form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter New Password (Leave blank to keep current)">
            </div>

            <div class="staff-form-group">
                <label for="phone">Phone</label>
                <input type="phone" id="phone" name="phone" value="<?= htmlspecialchars($staff['phone']) ?>" required>
            </div>

            <div class="staff-form-group">
                <label for="specialty">Specialty</label>
                <input type="text" id="specialty" name="specialty" value="<?= htmlspecialchars($staff['specialty']) ?>" required>
            </div>
            
            <button type="submit">Update Staff</button>

            
        </form>

        <!-- Back Button to redirect to addstaff.php -->
        <a href="addstaff.php">
            <button type="button" class="btn">Back</button>
        </a>
    </div>
</body>
</html>
