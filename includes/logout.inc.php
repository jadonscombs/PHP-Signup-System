<?php

// we need to START a session to clear and destroy the session
session_start();
session_unset();
session_destroy();

// redirect user and terminate script
header("Location: ../index.php");
die();