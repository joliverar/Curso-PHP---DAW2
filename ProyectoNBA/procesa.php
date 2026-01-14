<?php
require_once "conexionBD.php";
echo "<pre>";
print_r($_POST);
echo "</pre>";

if (
    !isset($_POST['equipo_baja'], $_POST['jugador_baja'],
            $_POST['nuevo_nombre'], $_POST['nuevo_peso'],
            $_POST['nuevo_procedencia'], $_POST['nuevo_altura'])
) {
    die("Faltan datos obligatorios");
}

$equipo = $_POST['equipo_baja'];
$jugadorBaja = $_POST['jugador_baja'];
$nuevoNombre = $_POST['nuevo_nombre'];
$nuevoPeso = $_POST['nuevo_peso'];
$nuevoProcedencia = $_POST['nuevo_procedencia'];
$nuevoAltura = $_POST['nuevo_altura'];

$pdo = getConexion();

try {
    //  INICIAR TRANSACCIÓN
    $pdo->beginTransaction();

    // 1) Borrar estadísticas del jugador
    $sql = "DELETE FROM estadisticas WHERE jugador = :jug";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":jug" => $jugadorBaja]);

    // 2) Dar de baja al jugador
    $sql = "DELETE FROM jugadores WHERE codigo = :jug AND nombre_equipo = :eq";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":jug" => $jugadorBaja,
        ":eq"  => $equipo
    ]);

    if ($stmt->rowCount() === 0) {
        throw new Exception("No se pudo borrar al jugador. No existe.");
    }

    // 3) Alta del nuevo jugador
    $sql = "INSERT INTO jugadores (nombre, peso, procedencia, altura, nombre_equipo)
            VALUES (:n, :p, :pr, :a, :eq)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":n"  => $nuevoNombre,
        ":p"  => $nuevoPeso,
        ":pr" => $nuevoProcedencia,
        ":a"  => $nuevoAltura,
        ":eq" => $equipo
    ]);

    //  CONFIRMAR TRANSACCIÓN
    $pdo->commit();

    echo "<h2>Operación realizada con éxito</h2>";
    echo "<p>Se dio de baja a <b>$jugadorBaja</b> y se dio de alta a <b>$nuevoNombre</b>.</p>";
    echo "<a href='index.php'>Volver</a>";

} catch (Exception $e) {

    //  ROLLBACK si algo falla
    $pdo->rollBack();

    echo "<h2>Error en la operación</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<a href='index.php'>Volver</a>";
}
?>
