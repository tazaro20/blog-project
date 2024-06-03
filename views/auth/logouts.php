<?php


session_start();

$_SESSION = [];

// Si vous voulez détruire complètement la session, vous devez également détruire le cookie de session.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}


session_destroy();


header('Location: ' .$router->url('login'));

exit();

