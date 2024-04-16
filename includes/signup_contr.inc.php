<?php

// we're now enforcing type declaration, so variables MUST be declared
// with/as a certain data type
declare(strict_types=1);

// helper function -- checks if any of the signup input fields are empty
function is_input_empty(string $username, string $pass, string $email) {
    if (empty($username) || empty($pass) || empty($email)) {
        return true;
    }
    return false;
}

/**
 * helper function -- check if given email is valid
 */
function is_email_invalid(string $email) {
    // use built-in filtering function + built-in email filter to check if
    // email is invalid or not
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

/**
 * helper function -- check if username specified during signup is taken;
 * IMPORTANT:
 *
 * since we are following the MVC model, this file is not allowed to interact
 * with or query our user database (user DB). instead, the MODEL component (our
 * 'signup_model.inc.php' file) must query the DB on our behalf.
 */
function is_username_taken(object $pdo, string $username) {
    if (get_username($pdo, $username)) {
        return true;
    }
    return false;
}

/** helper function -- check if email specified is taken;
 *
 * just like 'is_username_taken()', our MODEL component will have to query the
 * DB on our behalf
 */
function is_email_registered(object $pdo, string $email) {
    if (get_email($pdo, $email)) {
        return true;
    }
    return false;
}

/** helper function -- register the user in our DB
 * REMEMBER: because we need to insert data into the DB, our MODEL component will
 * be the one to handle db interaction
 */
function create_user(object $pdo, string $pass, string $username, string $email) {
    set_user($pdo, $pass, $username, $email);
}
