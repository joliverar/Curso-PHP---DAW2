<?php
session_start();

if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['domain'],
        $params['path'],
        $params['secure'],
        $params['httponly']
    );
}
session_unset();
session_destroy();
session_start();
$_SESSION['flash'] = 'Sesion cerrada correctamente';
header('Location: login.php');
exit;
