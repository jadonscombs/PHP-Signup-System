<?php

// MANDATORY SECURITY SETTINGS if you're using sessions
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

// (security) we are hardening our cookie a bit
//
// 'lifetime' -->   sets how long cookie lasts before it needs regeneration;
// 'domain' -->     sets which domain(s) the cookie will ONLY work in;
// 'path' -->       sets the path(s) the cookie is allowed to work in,
//                  usually (root folder of our website + any subfolders);
// 'secure' -->     forces cookie to only be used in SSL/TLS-secured website;
// 'httponly' -->   restricts cookie to ONLY be accessed using HTTP(s) protocol;
session_set_cookie_params([
    'lifetime' => 1800,
    'domain' => 'localhost',
    'path' => '/',
    'secure' => true,
    'httponly' => true
]);

// STARTING the session after setting some session config details
session_start();

// EXPERIMENTAL: micro-optimization
// temporary truth table to reduce redundant data access
$truths = [];
$truths["uid_set"] = isset($_SESSION["user_id"]);
$truths["last_regen_set"] = isset($_SESSION["last_regeneration"]);

if ($truths["uid_set"]) {
    // logic to regenerate session ID every X minutes;
    // should help prevent/reduce risk potential of attacker stealing 
    // & using an active session cookie
    if (!$truths["last_regen_set"]) {
        // custom function -- set new session ID (w/user ID appended to it)
        regenerate_session_id_loggedin();

    } else {
        $interval = 60 * 30;
        if (time() - $_SESSION["last_regeneration"] >= $interval) {
            // custom function -- set new session ID (w/user ID appended to it)
            regenerate_session_id_loggedin();
        }
    }
} else {
    if (!$truths["last_regen_set"]) {
        regenerate_session_id();

    } else {
        $interval = 60 * 30;
        if (time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_session_id();
        }
    }
}

// clear the truth table used for session ID management
unset($truths);


/**
 * helper function -- regenerate session ID and update timestamp
 */
function regenerate_session_id() {
    session_regenerate_id(true);
    $_SESSION["last_regeneration"] = time();
}

/**
 * helper function -- regenerate session ID and update timestamp
 */
function regenerate_session_id_loggedin() {
    session_regenerate_id(true);

    // create/replace current session ID with custom session ID
    $userId = $_SESSION["user_id"];
    $sessionId = session_create_id();
    $sessionId .= "_" . $userId; // appending user ID
    session_id($sessionId);

    $_SESSION["last_regeneration"] = time();
}