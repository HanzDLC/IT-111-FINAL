<?php
require_once 'UserController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $controller = new UserController();
    $message = $controller->handleSignUp($firstName, $lastName, $email, $password);
}
?>