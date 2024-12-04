<?php
require_once '../../controller/UserController.php';
require_once 'sidebar.php'; // Include sidebar.php

$userController = new UserController();

// Handle confirm or decline actions
if (isset($_GET['action'], $_GET['booking_id'])) {
    $bookingId = intval($_GET['booking_id']);
    $action = $_GET['action'];

    if ($action === 'confirm') {
        $isConfirmed = $userController->updateBookingStatus($bookingId, 'Confirmed');
        if ($isConfirmed) {
            echo "<p style='color: green;'>Booking confirmed successfully!</p>";
        } else {
            echo "<p style='color: red;'>Failed to confirm booking. Try again.</p>";
        }
    } elseif ($action === 'decline') {
        $isDeclined = $userController->updateBookingStatus($bookingId, 'Declined');
        if ($isDeclined) {
            echo "<p style='color: green;'>Booking declined successfully!</p>";
        } else {
            echo "<p style='color: red;'>Failed to decline booking. Try again.</p>";
        }
    }
}

// Fetch all bookings
$bookingList = $userController->getAllBookings();
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Bookings</title>
    <link rel="stylesheet" href="../assets/styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .booking-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        h2 {
            color: #1565c0;
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
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-green {
            background-color: #2e7d32;
            color: white;
        }

        .btn-red {
            background-color: #d32f2f;
            color: white;
        }

        .btn-green:hover {
            background-color: #1b5e20;
        }

        .btn-red:hover {
            background-color: #b71c1c;
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="booking-container">
            <h2>View Bookings</h2>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Customer Name</th>
                        <th>Package Name</th>
                        <th>Booking Date</th>
                        <th>Event Date</th>
                        <th>Status</th>
                        <th>Time Start</th>
                        <th>Time End</th>
                        <th>Total Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bookingList)) : ?>
                        <?php foreach ($bookingList as $booking) : ?>
                            <tr>
                                <td><?= htmlspecialchars($booking['booking_id']) ?></td>
                                <td><?= htmlspecialchars($booking['customer_name']) ?></td>
                                <td><?= htmlspecialchars($booking['package_name']) ?></td>
                                <td><?= htmlspecialchars($booking['booking_date']) ?></td>
                                <td><?= htmlspecialchars($booking['event_date']) ?></td>
                                <td><?= htmlspecialchars($booking['status']) ?></td>
                                <td><?= htmlspecialchars($booking['time_start']) ?></td>
                                <td><?= htmlspecialchars($booking['time_end']) ?></td>
                                <td><?= htmlspecialchars($booking['total_price']) ?></td>
                                <td>
                                    <button class="btn btn-green">Confirm</button>
                                    <button class="btn btn-red">Decline</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="10">No bookings available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>