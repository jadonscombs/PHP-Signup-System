<?php

declare(strict_types=1);

/** 
 * This function attempts to retrieve all records where the 'username'
 * field value matches the $username value. If no records found, a NULL
 * value is returned instead.
 */
function get_user(object $pdo, string $username) {
    // query statement to fetch any/all matching records
    $query = "SELECT * FROM users WHERE username = :username;";
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