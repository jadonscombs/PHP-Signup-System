<?php

// setting database object initialization parameters
//
// IMPORTANT:
// don't do this in production, because obviously we do NOT want
// our database password in cleartext OR held in version control
//
// please research other, more secure ways to initialize DB connection when
// needing to pass in sensitive data!
$host = 'localhost';
$dbname = 'myfirstdatabase';
$dbusername = 'root';
$dbpassword = '';

// safely attempt DB object creation (PDO = 'PHP Database Object')
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// if PDO can't be created, terminate script and notify user in website home
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}