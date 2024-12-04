<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="../css/global/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Log In</h2>

        <!-- Display success message if coming from successful sign-up -->
        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <p style="color: green; text-align: center;">Sign-up successful! Please log in.</p>
        <?php endif; ?>

        <form action="../controller/handleLogin.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Password" required>
            </div>

            <!-- Buttons to login as either User or Admin -->
            <button type="submit" name="login_type" value="user">Login as User</button>
            <button type="submit" name="login_type" value="admin">Login as Admin</button>

            <div class="forgot-password">
                <a href="#">Forgot password?</a>
            </div>
            <div class="sign-up">
                <!-- Corrected path for the sign-up page with proper HTML -->
                <label for="signup">Do not have an account?</label>
                <a href="../view/user/signup.php">Sign Up?</a>
            </div>
        </form>
    </div>
</body>
</html>
