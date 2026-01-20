<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Clases\ConexionBD;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['actualizar'])) {

    $pdo = ConexionBD::getConexion();
    try {

        $pdo->beginTransaction();
        foreach ($_POST['numero'] as $numero => $precio) {
            # code...
            $stmt = $pdo->prepare(
                'update plazas set precio = ? where numero = ?'
            );
            $stmt->execute([
                (float)$precio,
                (int)$numero,
            ]);
        }
        $pdo->commit();
        $msg = "Precios actualizados";
    } catch (PDOException $e) {
        //throw $th;
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $msg = "Error: " . $e->getMessage();
    }

    $smtp = $pdo->query(
        'select numero, reservada, precio from plazas where reservada = 0 order by numero'
    );
    $plazas = $smtp->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Resultado reserva</title>
</head>

<body>
    <main>
        <section>
            <div>
                <?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?>
            </div>
        </section>
    </main>
</body>

</html>