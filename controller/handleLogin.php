<?php
session_start();
require_once '../model/UserModel.php'; // Adjust the path to where your UserModel is located
$userModel = new UserModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $loginType = $_POST['login_type']; // user or admin
    
    // Debugging: Print received form data
    // echo "Email: $email, Password: $password, Login Type: $loginType";

    if ($loginType === 'user') {
        $user = $userModel->loginAsUser($email, $password);
        if ($user) {
            // Set session for user
            $_SESSION['user'] = $user;
            header("Location: ../index.php"); // Redirect to home page where user can see their name
            exit();
        } else {
            echo "<p style='color: red;'>Invalid credentials for User!</p>";
        }
    } elseif ($loginType === 'admin') {
        $admin = $userModel->loginAsAdmin($email, $password);
        if ($admin) {
            // Set session for admin
            $_SESSION['admin'] = $admin;
            header("Location: ../view/admin/dashboard.php"); // Redirect to dashboard
            exit();
        } else {
            echo "<p style='color: red;'>Invalid credentials for Admin!</p>";
        }
    }
}
    

?>
