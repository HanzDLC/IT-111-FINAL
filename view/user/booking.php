<?php
include_once "../../controller/session.php";

include_once '../../config/database.php';

$db = new Database();
$conn = $db->connect();

// Fetch packages from the database
$sql = "SELECT package_id, package_name, price, description FROM package";
$stmt = $conn->prepare($sql);
$stmt->execute();

$packages = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($packages)) {
    echo "No packages found.";
    exit();
}

// Handle AJAX request to update description and price dynamically
if (isset($_GET['package_id'])) {
    $package_id = intval($_GET['package_id']);

    $sql = "SELECT description, price FROM package WHERE package_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$package_id]);

    $package = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($package) {
        echo json_encode($package);
    } else {
        echo json_encode(['error' => 'Package not found']);
    }
    exit();
}

/// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the user is logged in and the session contains the necessary data
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['customer_id'])) {
        echo "Error: User is not logged in or customer ID is missing.";
        exit();
    }

    // Fetch the customer ID from the session
    $customer_id = $_SESSION['user']['customer_id'];

    $package_id = $_POST['package'];
    $event_date = $_POST['event_date'];
    $time_in = $_POST['time_in'];
    $time_out = $_POST['time_out'];
    $total_price = $_POST['price'];

    // Validate that the end time is after the start time
    $time_in_obj = new DateTime($time_in);
    $time_out_obj = new DateTime($time_out);

    if ($time_out_obj <= $time_in_obj) {
        echo "Error: The end time must be after the start time.";
        exit();
    }

    // Insert the booking data into the booking table
    $sql = "INSERT INTO booking (customer_id, package_id, booking_date, event_date, status, time_start, time_end, total_price)
            VALUES (?, ?, NOW(), ?, 'Pending', ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$customer_id, $package_id, $event_date, $time_in, $time_out, $total_price])) {
        echo "Booking successful!";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Booking Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #ffffff;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #1f1f1f;
            border-radius: 8px;
        }
        label {
            margin: 10px 0 5px;
            display: block;
            color: #eeeeee;
        }
        select, input[type="date"], input[type="time"], textarea {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #2c2c2c;
            color: #ffffff;
        }
        textarea {
            resize: none;
            height: 100px;
        }
    </style>
    <script>
        function updatePackageDetails() {
            const packageSelect = document.getElementById('package');
            const packageId = packageSelect.value;

            if (packageId) {
                fetch(`booking.php?package_id=${packageId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                        } else {
                            document.getElementById('description').value = data.description;
                            document.getElementById('price').value = data.price;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Package Booking Form</h2>
    <form id="booking-form" method="POST">
        <label for="package">Choose a Package:</label>
        <select id="package" name="package" required onchange="updatePackageDetails()">
            <option value="" disabled selected>Select a Package</option>
            <?php
            foreach ($packages as $package) {
                echo "<option value='" . $package['package_id'] . "'>" . htmlspecialchars($package['package_name']) . "</option>";
            }
            ?>
        </select>

        <label for="event_date">Event Date:</label>
        <input type="date" id="event_date" name="event_date" required min="<?php echo (new DateTime('now', new DateTimeZone('Asia/Manila')))->format('Y-m-d'); ?>">

        <label for="time_in">Start Time:</label>
        <input type="time" id="time_in" name="time_in" required>

        <label for="time_out">End Time:</label>
        <input type="time" id="time_out" name="time_out" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" readonly></textarea>

        <label for="price">Total Price:</label>
        <input type="number" id="price" name="price" readonly>

        <button type="submit">Book Now</button>

      
    </form>
    <button onclick="window.location.href='../../index.php';">Back</button>
</div>
</body>
</html>
