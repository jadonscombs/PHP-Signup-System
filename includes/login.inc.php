<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $pass = $_POST["pass"];

    try {

        // $pdo conn. object from 'dbh.inc.php' can be used onwards now
        require_once 'dbh.inc.php';
        require_once 'login_model.inc.php';
        require_once 'login_view.inc.php';
        require_once 'login_contr.inc.php';

        // error handling
        $errors = [];

        if (is_input_empty($username, $pass)) {
            $errors["empty_input"] = "Please fill in all fields.";
        }
        
        // get user data fetch outcome before checking if username is wrong;
        // NOTE: 'get_user()' fetches all fields for a given user (if found)
        $result = get_user($pdo, $username);
        if (is_username_wrong($result)) {
            $errors["login_incorrect"] = "Incorrect login info!";
        }

        // check for [correct username] but [wrong pass]
        if (
            !is_username_wrong($result) &&
            is_password_wrong($pass, $result["pass"])
        ) {
            $errors["login_incorrect"] = "Incorrect login info!";
        }

        // INCLUDE: the session startup/management block of code
        require_once 'config_session.inc.php';

        // check if any errors occurred here -- if so, redirect user to signup
        // page with error message(s) displayed; then terminate script
        if ($errors) {
            $_SESSION["errors_login"] = $errors;

            header("Location: ../index.php");
            die();
        }

        // NOW -- at this stage, user has input correct username + pass;
        // making new session ID for session security reasons
        $sessionId = session_create_id();
        $sessionId .= "_" . $result["id"]; // appending user ID
        
        // set current session ID to the one created above
        session_id($sessionId);

        // setting $_SESSION["user_id"] to the user ID from an internal DB;
        // we do this because we've validated that the user logging in DOES
        // exist in an internal database for our website, so the $_SESSION
        // variable's "user_id" value should reflect that
        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_username"] = (
            htmlspecialchars($result["username"])
        );
        $_SESSION["last_regeneration"] = time();

        // redirect user to main page, but indicate in client-accessible
        // variable "login" that the login is a success
        header("Location: ../index.php?login=success");
        
        // lastly (because user is now at a different page), setting the
        // $pdo and $stmt variables to null to clean up resources
        $pdo = null;
        $stmt = null;
        
        // terminate this script
        die();

    } catch (PDOException $e) {
        // display the exception occurred upon termination of this script
        die("Query failed: " . $e->getmessage());
    }
}
else {
    // redirect user to main page, then terminate this script
    header("Location: ../index.php");
    die();
}