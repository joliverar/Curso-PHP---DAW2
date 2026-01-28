<?php
declare(strict_types=1);

namespace App;

use App\Conexion;
use function \flash;
use function \iniciar_sesion;
use function \estaLogueado;
use function \redireccionar;
use function \esPost;
use PDO;
use RuntimeException;

/**
 * Clase responsable de la lógica de autenticación y control de acceso.
 *
 * Métodos públicos:
 * - inicializar(): prepara el entorno (sesiones).
 * - configurar(): crea la tabla usuarios y datos iniciales si es necesario.
 * - autenticar(): procesa el formulario de login.
 * - paginaLogin(): muestra la página de login (o redirige si ya está logueado).
 * - paginaConectado(): comprueba acceso y muestra la página protegida.
 * - desconectarse(): cierra la sesión del usuario.
 * - runAccion(): despacha la acción indicada por ?action=...
 */
class Autenticarse
{
    /**
     * Inicia la sesión (delegando en helper) para asegurarnos que $_SESSION esté disponible.
     */
    public static function inicializar(): void
    {
        iniciar_sesion();
    }

    /**
     * Crea la tabla usuarios si no existe y añade un usuario de ejemplo.
     *
     * Se usa al arrancar la aplicación para asegurar la existencia de la tabla.
     */
    public static function configurar(): void
    {
        // Obtener la conexión PDO desde el singleton Conexion
        $pdo = Conexion::get();

        // Sentencia para crear la tabla usuarios si no existe
        $sql = <<<SQL
CREATE TABLE IF NOT EXISTS usuarios (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user VARCHAR(190) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        // Ejecutar la creación de la tabla
        $pdo->exec($sql);

        // Insertar datos de ejemplo si no existen
        self::crearDatosUsuario($pdo);
    }

    /**
     * Inserta un usuario de ejemplo (educantabria@example.com / password) solo si no existe.
     *
     * @param PDO $pdo Conexión a la base de datos
     */
    private static function crearDatosUsuario(PDO $pdo): void
    {
        $email = 'educantabria@example.com';
        $pass = 'password';

        // Comprobar existencia del usuario
        $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE user = :u LIMIT 1');
        $stmt->execute([':u' => $email]);

        // Si no existe, insertar con password_hash (BCRYPT)
        if ($stmt->fetch() === false) {
            $hash = password_hash($pass, PASSWORD_BCRYPT);
            $ins = $pdo->prepare('INSERT INTO usuarios (user, password) VALUES (:u, :p)');
            $ins->execute([':u' => $email, ':p' => $hash]);
        }
    }

    /**
     * Procesa el formulario de autenticación.
     *
     * - Verifica que la solicitud sea POST.
     * - Si ya hay sesión activa redirige a la página conectada.
     * - Comprueba las credenciales contra la tabla usuarios y usa password_verify.
     * - En éxito crea la sesión del usuario; en fallo crea un mensaje flash y redirige.
     */
    public static function autenticar(): void
    {
        // Comprobar método HTTP
        if (!esPost()) {
            flash('error', 'Método HTTP no permitido');
            redireccionar('index.php?action=paginaLogin');
        }

        // Si ya está logueado, evitar doble login
        if (estaLogueado()) {
            redireccionar('index.php?action=paginaConectado');
        }

        // Recoger datos del POST
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Guardar el email en flash para repoblar el formulario en caso de error
        if ($email !== '') {
            flash('email', $email);
        }

        try {
            // Buscar usuario en BD
            $pdo = Conexion::get();
            $stmt = $pdo->prepare('SELECT id, password FROM usuarios WHERE user = :u LIMIT 1');
            $stmt->execute([':u' => $email]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar contraseña con password_verify
            if ($row && password_verify($password, (string)$row['password'])) {
                // Login correcto: iniciar sesión y almacenar datos mínimos
                iniciar_sesion();
                session_regenerate_id(true); // prevenir fijación de sesión
                $_SESSION['usuario_id'] = (int)$row['id'];
                $_SESSION['usuario'] = $email;

                // Redirigir a la página protegida
                redireccionar('index.php?action=paginaConectado');
            } else {
                // Credenciales incorrectas: mensaje y redirección al login
                flash('error', 'credenciales incorrectas');
                redireccionar('index.php?action=paginaLogin');
            }
        } catch (\Throwable $e) {
            // Errores internos: no exponer detalles, informar con mensaje genérico
            flash('error', 'Error de servidor');
            redireccionar('index.php?action=paginaLogin');
        }
    }

    /**
     * Comprueba acceso y redirige a la página conectada.
     *
     * Si no está logueado crea un mensaje flash y redirige al login.
     * Si está logueado carga la página protegida (archivo en public/).
     */
    public static function paginaConectado(): void
    {
        if (!estaLogueado()) {
            flash('error', 'No tienes acceso a esta página');
            redireccionar('index.php?action=paginaLogin');
        }

        // Mostrar la página protegida dentro de public/
        redireccionar('paginaConectado.php');
    }

    /**
     * Cierra la sesión del usuario y redirige al login.
     *
     * Elimina datos de $_SESSION, borra la cookie de sesión y destruye la sesión.
     */
    public static function desconectarse(): void
    {
        iniciar_sesion();

        // Limpiar datos de sesión
        $_SESSION = [];

        // Borrar cookie de sesión si existe
        if (ini_get('session.use_cookies')) {
            setcookie(session_name(), '', time() - 42000, '/');
        }

        // Destruir sesión en el servidor
        session_destroy();

        // Volver al login
        redireccionar('index.php?action=paginaLogin');
    }

    /**
     * Mostrar el formulario de login (o redirigir si ya está logueado).
     *
     * Redirige al archivo paginaLogin.php ubicado en public/.
     */
    public static function paginaLogin(): void
    {
        if (estaLogueado()) {
            redireccionar('index.php?action=paginaConectado');
        }

        // Mostrar el formulario de login
        redireccionar('paginaLogin.php');
    }

    /**
     * Despacha la acción indicada por la variable GET 'action'.
     *
     * Valores admitidos:
     * - paginaLogin
     * - autenticar
     * - paginaConectado
     * - desconectarse
     *
     * Si no se reconoce la acción, redirige al login por defecto.
     */
    public static function runAccion(): void
    {
        $accion = $_GET['action'] ?? 'paginaLogin';
        switch ($accion) {
            case 'paginaLogin':
                self::paginaLogin();
                break;
            case 'autenticar':
                self::autenticar();
                break;
            case 'paginaConectado':
                self::paginaConectado();
                break;
            case 'desconectarse':
                self::desconectarse();
                break;
            default:
                // Acción desconocida: volver al login
                redireccionar('index.php?action=paginaLogin');
        }
    }
}