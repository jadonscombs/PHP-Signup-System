<?php

declare(strict_types=1);

/** 
 * helper function -- return true if any specified input fields are empty
 */ 
function is_input_empty(string $username, string $pass) {
    if (empty($username) || empty($pass)) {
        return true;
    }
    return false;
}

/** 
 * This function checks the $result param; returning true means username
 * was NOT found in the queried database.
 *
 * $result will be of type 'bool' if/when it returns a "NULL" result
 * from the internal query sent to the backend.
 * 
 * $result will be of type 'array' if/when it returns an array, which
 * indicates the username queried IS found in the queried database.
*/
function is_username_wrong(bool|array $result) {
    if (!$result) {
        return true;
    }
    return false;
}

/**
 * helper function. use built-in 'password_verify()' function to check
 * entered password against DB-stored hashed password for the target account.
 * 
 * NOTE:
 * it is implied that the hashed password comes from the correct user
 * record, as this function is called with the user data already retrieved,
 * within the "login.inc.php" file
 */
function is_password_wrong(string $pass, string $hashedPass) {
    /*  This function compares an entered password with an internal password
        and returns true if the passwords DO NOT match.
    */
    if (!password_verify($pass, $hashedPass)) {
        return true;
    }
    return false;
}