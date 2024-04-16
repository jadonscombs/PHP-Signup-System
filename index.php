<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/signup_view.inc.php';
require_once 'includes/login_view.inc.php';
?>

<!--
    AUTHOR NOTE:
    This project follows a PHP mini-series from Dani Krossing, and is not
    original in idea. Instead it is an applied example of PHP within a locally
    hosted website, to demonstrate implementation of MVC-based code and basic
    security functions that are essential at the very least when hosting a
    website utilizing PHP for backend processing.

    Thank you!
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- display logic to indicate whether user is signed in -->
    <h3>
        <?php
        output_username();
        ?>
    </h3>

    <!-- if user NOT logged in, display login option -->
    <?php if (!isset($_SESSION["user_id"])) { ?>
        <h3>Login</h3>

        <form action="includes/login.inc.php" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="pass" placeholder="Password">
            <button>Login</button>
        </form>

    <?php } ?>
    <!-- validate user input from login fields -->
    <?php check_login_errors(); ?>

    <!-- if user NOT logged in, run through signup display logic -->
    <?php if (!isset($_SESSION["user_id"])) { ?>
        <h3>Signup</h3>

        <form action="includes/signup.inc.php" method="post">
            <?php
            signup_inputs();
            ?>
            <button>Signup</button>
        </form>
    <?php } ?>

    <!-- validate user input from signup fields -->
    <?php check_signup_errors(); ?>

    <!-- if user IS logged in, display logout option -->
    <?php if (isset($_SESSION["user_id"])) { ?>
        <h3>Logout</h3>
    
        <form action="includes/logout.inc.php" method="post">
            <button>Logout</button>
        </form>
    <?php } ?>
    
</body>
</html>