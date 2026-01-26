<?php
// login.php
session_start();

// Si ya está logueado, redirigir
if (!empty($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Usuario de ejemplo (en real → BD + password_verify)
    $emailValido = 'admin@example.com';
    $passwordValida = 'secreto123';

    if ($email === $emailValido && $password === $passwordValida) {

        // Seguridad: evitar session fixation
        session_regenerate_id(true);

        $_SESSION['user'] = [
            'email' => $email,
            'login_at' => time()
        ];

        header('Location: dashboard.php');
        exit;

    } else {
        $error = 'Credenciales inválidas';
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>
<body>

<h1>Login</h1>

<?php if ($error): ?>
<p style="color:red;">
    <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
</p>
<?php endif; ?>

<form method="post" action="login.php">
    <label>
        Email:
        <input type="email" name="email" required>
    </label><br><br>

    <label>
        Password:
        <input type="password" name="password" required>
    </label><br><br>

    <button type="submit">Entrar</button>
</form>

</body>
</html>
