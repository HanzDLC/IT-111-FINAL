<?php
session_start();

// Header section
echo "<title>Vivir Studios</title>";
echo "<div>";
include_once('./view/user/header.php');
echo "</div>";

// Content section
echo "<div>";
include_once("controller/UserController.php");
$controller = new UserController();
$controller->getPage();
echo "</div>";

// Footer section
echo "<div>";
include_once('./view/user/footer.php');
echo "</div>";
?>
