<?php
session_start();
$_SESSION = array();

// If desired, delete the session cookie as well
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

// Redirect the user to the login page.
header("Location: index.php");
exit;
?>
