<?php
$message = $message ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../../css/global/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Sign Up</h2>

        <!-- Display Success/Failure Message -->
        <?php if ($message): ?>
            <p style="color: <?= strpos($message, 'successful') !== false ? 'green' : 'red'; ?>;">
                <?= htmlspecialchars($message); ?>
            </p>
        <?php endif; ?>

        <form action="../../controller/handleSignUp.php" method="POST">
            <div class="form-group">
                <label for="first-name">First Name</label>
                <input type="text" id="first-name" name="first-name" placeholder="Enter First Name" required>
            </div>
            <div class="form-group">
                <label for="last-name">Last Name</label>
                <input type="text" id="last-name" name="last-name" placeholder="Enter Last Name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Password" required>
            </div>
            <button type="submit" class="btn">Sign Up</button>
            <div class="login-link">
                <p>Already have an account? <a href="../../view/login.php">Sign In</a></p>
            </div>
        </form>
    </div>
</body>
</html>
