<?php

declare(strict_types=1);


/** helper function to retrieve DB records matching the target username
 *
 * NOTE: because this file (signup_model.inc.php) during active use
 * is actually included after our 'dbh.inc.php' file is included,
 * passing in the "$pdo" parameter for our (identically named) $pdo
 * parameter below will WORK because 'dbh.inc.php' will have already
 * defined $pdo fully beforehand
 */
function get_username(object $pdo, string $username) {

    // query statement to fetch username
    $query = "SELECT username FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    // not using "fetchAll()" because we only need FIRST result;
    // we also specify *how* we want to fetch the query results,
    // by saying "PDO::FETCH_ASSOC", which means we'll have the
    // query data returned as an *ASSOCIATIVE* array that we can
    // reference by column name (colname)
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

/** 
 * helper function to retrieve username from DB with matching target email
*/
function get_email(object $pdo, string $email) {

    // query statement to fetch the user with a matching email (if any)
    $query = "SELECT username FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    // not using "fetchAll()" because we only need FIRST result;
    // we also specify *how* we want to fetch the query results,
    // by saying "PDO::FETCH_ASSOC", which means we'll have the
    // query data returned as an *ASSOCIATIVE* array that we can
    // reference by column name (colname)
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

/**
 * helper function to create a new record in DB for new user
 * 
 * the new record should populate the 'username', 'pass' and 'email' fields
 */
function set_user(object $pdo, string $pass, string $username, string $email) {
    $query = "INSERT INTO users (username, pass, email) 
        VALUES (:username, :pass, :email);";
    $stmt = $pdo->prepare($query);

    // setting 'cost' to 12 means our hashing algorithm will COST more
    // resources to run, which in turn makes it more difficult for threat
    // actors to brute force a hash
    $options = [
        'cost' => 12
    ];

    // use built-in 'password_hash()' func to return hashed version of password
    $hashedPass = password_hash($pass, PASSWORD_BCRYPT, $options);

    // bind/replace query parameters with static values
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":pass", $hashedPass);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
}