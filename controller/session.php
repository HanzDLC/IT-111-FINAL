<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if a user is logged in
if (isset($_SESSION['user'])) {
    // Store user details in variables
    $firstName = $_SESSION['user']['fname']; // Assuming 'fname' is the column for first name
    // You can also store other user details like email, role, etc.
} else {
    // If no user is logged in, handle accordingly (e.g., set $firstName to null or redirect)
    $firstName = null;
}
?>
