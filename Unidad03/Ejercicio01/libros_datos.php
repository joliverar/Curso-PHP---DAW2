<?php
require_once 'funcionesBD.php';

$libros = getLibros();

echo '<pre>';
print_r($libros);
echo '</pre>';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de libros</title>
</head>

<body>
    <?php if (!empty($libros)): ?>
        <div class="tabla">
            <div class="cabecera">
                <div>Titulo</div>
                <div>Precio</div>
            </div>
            <?php foreach ($libros as $libro): ?>
                <div class="filas">
                    <div><?= htmlspecialchars($libro["titulo"]) ?></div>
                    <div><?= htmlspecialchars($libro["precio"]) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No hay libros registrados</p>
    <?php endif; ?>
</body>

</html>