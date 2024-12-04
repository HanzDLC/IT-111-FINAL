<?php


include_once "controller/session.php";
?>

<header>
    <div class="header-content">
        <a href="#"><img class="logo" src="assets/viv lighter.png" height="150" width="150"></a>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php?default=Home">HOME</a></li>
                <li><a href="index.php?default=About">ABOUT</a></li>
                <li><a href="index.php?default=Services">SERVICES</a></li>
                <li><a href="index.php?default=Projects">PROJECTS</a></li>
                <li><a href="index.php?default=Contacts">CONTACT</a></li>
            </ul>
        </nav>
        
        <!-- Login/Logout Section -->
        <div class="login">
            <?php 
            if ($firstName) {
                // If the user is logged in, show their name and a logout link
                echo "<p>Welcome, $firstName!</p>
                      <a href='view/logout.php'>Log out</a>";
            } else {
                // If not logged in, show login and signup links
                echo "<a href='view/login.php'>Log in</a>
                      <a href='view/user/signup.php'>Sign up</a>";
            }
            ?>
        </div>

        <div class="social-links">
            <a href="https://www.facebook.com/romeo.gascon.509"><img src="assets/facebook.png" height="24" width="24"></a>
            <a href="#"><img src="assets/twitter.png" height="24" width="24"></a>
            
        </div>
    </div>
</header>
