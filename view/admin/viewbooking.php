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
        $message = $isConfirmed ? 'Booking confirmed successfully!' : 'Failed to confirm booking.';
    } elseif ($action === 'decline') {
        $isDeclined = $userController->updateBookingStatus($bookingId, 'Declined');
        $message = $isDeclined ? 'Booking declined successfully!' : 'Failed to decline booking.';
    }
    
    // Redirect back to the viewbooking page, without the action and booking_id in the URL
    header("Location: viewbooking.php");
    exit; // Ensure the script stops executing after the redirect
}

// Fetch all bookings based on status
$pendingBookings = $userController->getBookingsByStatus('Pending');
$confirmedBookings = $userController->getBookingsByStatus('Confirmed');
$declinedBookings = $userController->getBookingsByStatus('Declined');
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
        <!-- Pending Bookings Table -->
        <div class="booking-container">
            <h2>Pending Bookings</h2>
            <table id="pendingTable">
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
                    <?php if (!empty($pendingBookings)) : ?>
                        <?php foreach ($pendingBookings as $booking) : ?>
                            <tr id="booking<?= $booking['booking_id'] ?>">
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
                                    <button type="button" class="btn btn-green btn-confirm" data-booking-id="<?= $booking['booking_id'] ?>">Confirm</button>
                                    <button type="button" class="btn btn-red btn-decline" data-booking-id="<?= $booking['booking_id'] ?>">Decline</button>
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

        <!-- Confirmed Bookings Table -->
        <div class="booking-container">
            <h2>Confirmed Bookings</h2>
            <table id="confirmedTable">
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
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($confirmedBookings)) : ?>
                        <?php foreach ($confirmedBookings as $booking) : ?>
                            <tr id="booking<?= $booking['booking_id'] ?>">
                                <td><?= htmlspecialchars($booking['booking_id']) ?></td>
                                <td><?= htmlspecialchars($booking['customer_name']) ?></td>
                                <td><?= htmlspecialchars($booking['package_name']) ?></td>
                                <td><?= htmlspecialchars($booking['booking_date']) ?></td>
                                <td><?= htmlspecialchars($booking['event_date']) ?></td>
                                <td><?= htmlspecialchars($booking['status']) ?></td>
                                <td><?= htmlspecialchars($booking['time_start']) ?></td>
                                <td><?= htmlspecialchars($booking['time_end']) ?></td>
                                <td><?= htmlspecialchars($booking['total_price']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="9">No confirmed bookings available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Declined Bookings Table -->
        <div class="booking-container">
            <h2>Declined Bookings</h2>
            <table id="declinedTable">
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
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($declinedBookings)) : ?>
                        <?php foreach ($declinedBookings as $booking) : ?>
                            <tr id="booking<?= $booking['booking_id'] ?>">
                                <td><?= htmlspecialchars($booking['booking_id']) ?></td>
                                <td><?= htmlspecialchars($booking['customer_name']) ?></td>
                                <td><?= htmlspecialchars($booking['package_name']) ?></td>
                                <td><?= htmlspecialchars($booking['booking_date']) ?></td>
                                <td><?= htmlspecialchars($booking['event_date']) ?></td>
                                <td><?= htmlspecialchars($booking['status']) ?></td>
                                <td><?= htmlspecialchars($booking['time_start']) ?></td>
                                <td><?= htmlspecialchars($booking['time_end']) ?></td>
                                <td><?= htmlspecialchars($booking['total_price']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="9">No declined bookings available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
    // Add event listeners to buttons for confirming or declining bookings
    document.querySelectorAll('.btn-confirm').forEach(button => {
        button.addEventListener('click', function() {
            const bookingId = this.getAttribute('data-booking-id');
            // Use a fetch request to perform the action and reload the page after a successful update
            fetch(`viewbooking.php?action=confirm&booking_id=${bookingId}`)
                .then(response => {
                    location.reload();  // Reload the page to reflect updated bookings
                })
                .catch(error => {
                    alert('Error confirming booking.');
                });
        });
    });

    document.querySelectorAll('.btn-decline').forEach(button => {
        button.addEventListener('click', function() {
            const bookingId = this.getAttribute('data-booking-id');
            // Use a fetch request to perform the action and reload the page after a successful update
            fetch(`viewbooking.php?action=decline&booking_id=${bookingId}`)
                .then(response => {
                    location.reload();  // Reload the page to reflect updated bookings
                })
                .catch(error => {
                    alert('Error declining booking.');
                });
        });
    });
</script>


</body>
</html>
