<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // gathering signup details
    $username = $_POST["username"];
    $pass = $_POST["pass"];
    $email = $_POST["email"];

    try {

        require_once 'dbh.inc.php';
        require_once 'signup_model.inc.php';
        require_once 'signup_contr.inc.php';

        // error handling
        $errors = [];

        if (is_input_empty($username, $pass, $email)) {
            $errors["empty_input"] = "Please fill in all fields.";
        }
        if (is_email_invalid($email)) {
            $errors["invalid_email"] = "Invalid email used.";
        }
        if (is_username_taken($pdo, $username)) {
            $errors["username_taken"] = "Username already taken.";
        }
        if (is_email_registered($pdo, $email)) {
            $errors["email_used"] = "Email already registered.";
        }

        // INCLUDE: the session startup/management block of code
        require_once 'config_session.inc.php';

        // check if any errors occurred here -- if so, redirect user to signup page
        // with error message(s) displayed; then terminate script
        if ($errors) {
            $_SESSION["errors_signup"] = $errors;

            // usability feature -- sending back valid data to the form, so the
            // user doesn't have to re-type all fields every time
            $signupData = [
                "username" => $username,
                "email" => $email
            ];

            $_SESSION["signup_data"] = $signupData;

            // redirect user to home page, terminate this script
            header("Location: ../index.php");
            die();
        }

        // function to actually sign up/register the user in our DB
        create_user($pdo, $pass, $username, $email);

        header("Location: ../index.php?signup=success");

        // clean up resources, terminate script
        $pdo = null;
        $stmt = null;
        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getmessage());
    }
} else {
    header("Location: ../index.php");
    die();
}