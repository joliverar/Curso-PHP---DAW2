<?php
// dashboard.php
session_start();

if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
</head>
<body>

<h1>Área privada</h1>

<p>
    Bienvenido:
    <?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?>
</p>

<p>
    Sesión iniciada en:
    <?php echo date('Y-m-d H:i:s', $user['login_at']); ?>
</p>

<p>
    <a href="logout.php">Cerrar sesión</a>
</p>

</body>
</html>
