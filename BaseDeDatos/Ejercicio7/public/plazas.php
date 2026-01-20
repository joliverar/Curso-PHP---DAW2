<?php

declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Clases\ConexionBD;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');

$dotenv->load();
$pdo = ConexionBD::getConexion();
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  isset($_POST['actualizar'])) {
    try {
        //code...

        $pdo->beginTransaction();
        foreach ($_POST['precio'] as $numero => $precio) {
            # code...
            $stmt = $pdo->prepare('
                update plazas set precio = ? where numero = ?
            ');

            $stmt->execute([
                (float)$precio,
                (int)$numero
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
}

$plazas = $pdo->query('
    select numero, reservada, precio from plazas order by numero
')->fetchAll(PDO::FETCH_ASSOC);


// echo '<pre>';
// var_dump($plazas);
// echo '</pre>';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Plazas</title>
</head>

<body>
    <main>
        <?php if ($msg !== ''): ?>
            <section class="msg <?= strpos($msg, 'Error') !== false ? 'error' : 'success' ?> ">
                <?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?>

            </section>
        <?php endif; ?>
        <section class="formulario">
            <form method="post" action="plazas.php">
                <table>
                    <thead>
                        <tr>

                            <th>Numero</th>
                            <th>Reservada</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($plazas as $p): ?>
                            <tr>
                                <td><?= (int)$p['numero'] ?>
                                </td>
                                <td><?= (int)$p['reservada'] ? 'si' : 'no' ?>
                                </td>
                                <td><input type="number"
                                        step="0.01" name="precio[<?= (int)$p['numero'] ?>]" value="<?= htmlspecialchars((string)$p['precio'], ENT_QUOTES, 'UTF-8') ?>">
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
                <button type="submit" name="actualizar">Actualizar precios</button>
            </form>
        </section>

    </main>
</body>

</html>