
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilo.css">
    <title>Document</title>
</head>
<body>
    <div class="contenedor">
    <form action="libros_guardar.php" method="post">
    <h2>Inserte los datos del libro</h2>
    <label>Titulo *</label>
    <input type="text" name="nombre">
    <label>Año de edición *</label>
    <input type="number" name="anio">
    <label>Precio *</label>
    <input type="number" name="precio" >
    <label>Fecha de adquisición</label>
    <input type="date" name="fecha" >
     <div class="error"><?= $error; ?></div>
    <button type="submit" name="guardar">Grardar datos del libro</button>

<p>  <a href="">Mostrar libros guardados</a></p>
 
    </div>
</form>
    
</body>
</html>