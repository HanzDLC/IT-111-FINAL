<?php
require_once '../../controller/UserController.php';
require_once 'sidebar.php';  // Include sidebar.php

$userController = new UserController();

// Handle form submission to add equipment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isAdded = $userController->handleAddEquipment($_POST);
    if ($isAdded) {
        echo "<p style='color: green;'>Equipment added successfully!</p>";
    } else {
        echo "<p style='color: red;'>Failed to add equipment. Try again.</p>";
    }
}

// Handle equipment deletion
if (isset($_GET['delete'])) {
    $equipmentId = $_GET['delete'];
    $isDeleted = $userController->handleDeleteEquipment($equipmentId);
    if ($isDeleted) {
        echo "<p style='color: green;'>Equipment deleted successfully!</p>";
    } else {
        echo "<p style='color: red;'>Failed to delete equipment. Try again.</p>";
    }
}

// Fetch all equipment
$equipmentList = $userController->getAllEquipment();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Equipment</title>
    <link rel="stylesheet" href="../assets/styles.css"> <!-- Adjust path to match your project -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .equipment-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        h2 {
            color: #1565c0;
        }

        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #90caf9;
            border-radius: 5px;
        }

        button {
            background-color: #1565c0;
            color: #ffffff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0d47a1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #1565c0;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f1f8e9;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            background-color: #d32f2f;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #b71c1c;
        }
    </style>
</head>
<body>
    <!-- Content Area -->
    <div class="content">
        <div class="equipment-container">
            <h2>Add Equipment</h2>
            <form action="addEquipment.php" method="POST">
                <label for="equipment_name">Equipment Name</label>
                <input type="text" id="equipment_name" name="equipment_name" placeholder="Enter Equipment Name" required>

                <label for="type">Type</label>
                <input type="text" id="type" name="type" placeholder="Enter Equipment Type" required>

                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" placeholder="Enter Quantity" required>
                <button type="submit">Add Equipment</button>
            </form>
        </div>

        <div class="equipment-container">
    <h2>Registered Equipment</h2>
    <table>
        <thead>
            <tr>
                <th>Equipment ID</th>
                <th>Equipment Name</th>
                <th>Type</th>
                <th>Quantity</th> <!-- Added the Quantity column -->
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($equipmentList)) : ?>
                <?php foreach ($equipmentList as $equipment) : ?>
                    <tr>
                        <td><?= htmlspecialchars($equipment['equipment_id']) ?></td>
                        <td><?= htmlspecialchars($equipment['equipment_name']) ?></td>
                        <td><?= htmlspecialchars($equipment['type']) ?></td>
                        <td><?= htmlspecialchars($equipment['quantity']) ?></td> <!-- Display quantity here -->
                        <td>
                            <a href="editEquipment.php?edit=<?= htmlspecialchars($equipment['equipment_id']) ?>" class="btn">Edit</a>
                            <a href="addEquipment.php?delete=<?= htmlspecialchars($equipment['equipment_id']) ?>" class="btn">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5">No equipment registered yet.</td> <!-- Adjusted colspan to match new column -->
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
    </div>
</body>
</html>