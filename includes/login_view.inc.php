<?php

declare(strict_types=1);

/**
 * this function displays welcome message if user is logged in,
 * otherwise it will indicate user is not logged in
 */
function output_username() {
    if (isset($_SESSION["user_id"])) {
        echo 'You are logged in as ' . $_SESSION["user_username"];
    } else {
        echo 'You are not logged in';
    }
}

/**
 * function to check for and display any login errors
 */
function check_login_errors() {

    // if there are login errors, output them to the user
    if (isset($_SESSION["errors_login"])) {
        $errors = $_SESSION["errors_login"];

        echo '<br>';

        // print each error
        foreach ($errors as $error) {
            echo '<p>' . $error . '</p>';
        }

        // clear the $_SESSION["errors_login"] variable data
        unset($_SESSION["errors_login"]);
    }

    // NOTE: the 'login' var inside $_GET comes from a manually specified param.
    // 'login=success' when we redirect a user after a successful login
    else if (isset($_GET['login']) && $_GET['login'] === "success") {
        echo '<br>';
        echo '<p>Login success!</p>';
    }
}