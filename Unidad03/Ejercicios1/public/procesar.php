<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
use App\Clases\ConexionBD;

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || ($_POST['accion'] ?? '') !== 'swap') {
    header('Location: index.php');
    exit;
}

// recoger y validar datos
$equipo = trim((string)($_POST['equipo'] ?? ''));
$codigoBaja = isset($_POST['jugador_baja']) ? (int) $_POST['jugador_baja'] : 0;
$nombreNuevo = trim((string)($_POST['nombre_nuevo'] ?? ''));
$procedencia = trim((string)($_POST['procedencia_nueva'] ?? ''));
$altura = trim((string)($_POST['altura_nueva'] ?? ''));
$peso = trim((string)($_POST['peso_nuevo'] ?? ''));
$posicion = trim((string)($_POST['posicion_nueva'] ?? ''));

// validaciones básicas
if ($equipo === '' || $codigoBaja <= 0 || $nombreNuevo === '' || $altura === '' || $peso === '') {
    header('Location: index.php?error=1');
    exit;
}
if (!is_numeric($altura) || !is_numeric($peso)) {
    header('Location: index.php?error=2');
    exit;
}

// convertir alturas/peso a formato adecuado
$altura = (float) $altura;
$peso = (float) $peso;

$pdo = ConexionBD::getConexion();

try {
    // empezar transacción
    $pdo->beginTransaction();

    // Comprobar que el jugador a dar de baja existe y pertenece al equipo
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM jugadores WHERE codigo = ? AND nombre_equipo = ?");
    $stmt->execute([$codigoBaja, $equipo]);
    $existeBaja = (int)$stmt->fetchColumn();
    if ($existeBaja === 0) {
        $pdo->rollBack();
        header('Location: index.php?error=3'); // jugador a baja no existe / no pertenece al equipo
        exit;
    }

    // 1) borrar estadísticas del jugador a dar de baja
    $stmt = $pdo->prepare("DELETE FROM estadisticas WHERE jugador = ?");
    $stmt->execute([$codigoBaja]);

    // 2) borrar jugador
    $stmt = $pdo->prepare("DELETE FROM jugadores WHERE codigo = ? AND nombre_equipo = ?");
    $stmt->execute([$codigoBaja, $equipo]);
    if ($stmt->rowCount() === 0) {
        // no se borró (coherencia)
        $pdo->rollBack();
        header('Location: index.php?error=5');
        exit;
    }

    // 3) insertar nuevo jugador (sin especificar 'codigo' — la BD lo genera)
    $stmt = $pdo->prepare("INSERT INTO jugadores (nombre, procedencia, altura, peso, posicion, nombre_equipo) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $nombreNuevo,
        $procedencia === '' ? null : $procedencia,
        $altura,
        $peso,
        $posicion === '' ? null : $posicion,
        $equipo
    ]);

    // confirmar transacción
    $pdo->commit();
    header('Location: index.php?success=1&equipo=' . urlencode($equipo));
    exit;

} catch (\PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    // error_log($e->getMessage());
    header('Location: index.php?error=6');
    exit;
}

