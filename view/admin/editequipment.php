<?php
require_once '../../controller/UserController.php';

$userController = new UserController();

// Fetch the equipment to be edited (if the 'edit' parameter is passed)
if (isset($_GET['edit'])) {
    $equipmentId = $_GET['edit'];
    $equipment = $userController->getEquipmentById($equipmentId); // Fetch equipment by ID
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission to update equipment
    $isUpdated = $userController->handleUpdateEquipment($_POST); // Pass $_POST directly to handleUpdateEquipment
    if ($isUpdated) {
        echo "<p style='color: green;'>Equipment updated successfully!</p>";
    } else {
        echo "<p style='color: red;'>Failed to update equipment. Try again.</p>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Equipment</title>
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

        .equipment-container {
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

        .equipment-form-group {
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

            .equipment-container {
                width: 95%;
            }
        }
    </style>
</head>

<body>
    <div class="equipment-container">
        <h2>Edit Equipment</h2>
        <form action="editequipment.php?edit=<?= htmlspecialchars($equipment['equipment_id']) ?>" method="POST">
            <!-- Hidden input field for equipment_id -->
            <input type="hidden" name="equipment-id" value="<?= htmlspecialchars($equipment['equipment_id']) ?>">

            <div class="equipment-form-group">
                <label for="equipment-name">Equipment Name</label>
                <input type="text" id="equipment-name" name="equipment-name" value="<?= htmlspecialchars($equipment['equipment_name']) ?>" required>
            </div>

            <div class="equipment-form-group">
                <label for="type">Type</label>
                <input type="text" id="type" name="type" value="<?= htmlspecialchars($equipment['type']) ?>" required>
            </div>

            <div class="equipment-form-group">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" value="<?= htmlspecialchars($equipment['quantity']) ?>" required>
            </div>

            <button type="submit">Update Equipment</button>
        </form>

        <!-- Back Button to redirect to addequipment.php -->
        <a href="addequipment.php">
            <button type="button" class="btn">Back</button>
        </a>
    </div>
</body>

</html>
