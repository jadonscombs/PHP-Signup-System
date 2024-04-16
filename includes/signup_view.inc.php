<?php

declare(strict_types=1);

/**
 * logic to determine what is displayed on home page, based on signup inputs
 */
function signup_inputs() {
    // display username logic on signup
    if (isset($_SESSION["signup_data"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"])) {
        echo '<input type="text" name="username" placeholder="Username" value="' . $_SESSION["signup_data"]["username"] . '">';
    }
    else {
        echo '<input type="text" name="username" placeholder="Username">';
    }

    // display password logic on signup (placeholder-only)
    echo '<input type="password" name="pass" placeholder="Password">';

    // display email logic on signup
    if (isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["errors_signup"]["email_used"]) && !isset($_SESSION["errors_signup"]["invalid_email"])) {
        echo '<input type="text" name="email" placeholder="E-Mail" value="' . $_SESSION["signup_data"]["email"] . '">';
    }
    else {
        echo '<input type="text" name="email" placeholder="E-Mail">';
    }

}

/**
 * function to check $_SESSION superglobal for any signup errors
 */
function check_signup_errors() {

    // if there is ANY data in $_SESSION['errors_signup']...
    if (isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION['errors_signup'];

        // print out each error that occurred, to the signup page
        echo "<br>";
        foreach ($errors as $error) {
            echo '<p>' . $error . '</p>';
        }

        // clear the 'errors_signup' $_SESSION data  since we're done with them
        unset($_SESSION['errors_signup']);
    }

    // otherwise if user *has* signed up, display that status to the user
    else if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo "<br>";
        echo "<p>Signup success!</p>";
    }
}