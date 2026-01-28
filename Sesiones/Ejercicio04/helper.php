<?php
declare(strict_types=1);

/**
 * Inicia la sesión si no está iniciada.
 *
 * Evita llamadas repetidas a session_start() y asegura que $_SESSION
 * esté disponible antes de manipular datos de sesión.
 */
function iniciar_sesion(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Mensajes flash (persisten solo hasta la siguiente petición).
 *
 * Uso:
 * - Para escribir: flash('error', 'Mensaje de error');
 * - Para leer y borrar: $msg = flash('error'); // devuelve string|null
 *
 * Internamente usamos $_SESSION['flash'][$clave].
 *
 * @param string $clave  Nombre del mensaje (p. ej. 'error', 'ok', 'email')
 * @param string|null $mensaje  Si se proporciona, crea/actualiza la flash; si es null, lee y borra.
 * @return string|null  Devuelve el mensaje creado o el mensaje leído, o null si no existe.
 */
function flash(string $clave, ?string $mensaje = null): ?string
{
    // Asegurar sesión activa
    iniciar_sesion();

    // Inicializar contenedor flash si no existe
    if (!isset($_SESSION['flash']) || !is_array($_SESSION['flash'])) {
        $_SESSION['flash'] = [];
    }

    // Si se pasa $mensaje => almacenar y devolverlo
    if ($mensaje !== null) {
        $_SESSION['flash'][$clave] = $mensaje;
        return $mensaje;
    }

    // Si no se pasa $mensaje => devolver el valor y eliminar la clave
    if (array_key_exists($clave, $_SESSION['flash'])) {
        $val = $_SESSION['flash'][$clave];
        unset($_SESSION['flash'][$clave]);
        return $val;
    }

    return null;
}

/**
 * Comprueba si hay un usuario logueado.
 *
 * La lógica del proyecto almacena el id de usuario en $_SESSION['usuario_id']
 * cuando el usuario se autentica correctamente.
 *
 * @return bool true si hay sesión de usuario, false en caso contrario.
 */
function estaLogueado(): bool
{
    iniciar_sesion();
    return !empty($_SESSION['usuario_id']);
}

/**
 * Redirecciona inmediatamente a la URL indicada y detiene la ejecución.
 *
 * @param string $url URL a la que redireccionar (relativa o absoluta).
 */
function redireccionar(string $url): void
{
    header('Location: ' . $url);
    exit;
}

/**
 * Comprueba si la petición actual utiliza el método HTTP POST.
 *
 * Útil para validar formularios y evitar manejar datos en GET.
 *
 * @return bool true si es POST, false en caso contrario.
 */
function esPost(): bool
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}