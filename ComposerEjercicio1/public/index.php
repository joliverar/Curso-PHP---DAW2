<!doctype html>
<!-- Documento HTML5 -->
<html lang="es">
<!-- Idioma del documento: español -->
<head>
    <!-- Metadatos del documento -->
    <meta charset="utf-8">
    <!-- Título que aparece en la pestaña del navegador -->
    <title>Generador de contraseñas</title>
</head>
<body>
    <!-- Encabezado principal de la página -->
    <h1>Generador de contraseñas</h1>

    <!-- Formulario que envía por POST a procesa.php -->
    <form method="post" action="procesa.php">
        <!-- Campo para especificar la longitud de la contraseña -->
        <label>
            Longitud:
            <!-- Input numérico con límites y valor por defecto -->
            <input type="number" name="length" min="4" max="128" value="12" required>
        </label>
        <br>
        <!-- Checkbox para incluir mayúsculas -->
        <label><input type="checkbox" name="upper" checked> Mayúsculas</label>
        <!-- Checkbox para incluir minúsculas -->
        <label><input type="checkbox" name="lower" checked> Minúsculas</label>
        <!-- Checkbox para incluir números -->
        <label><input type="checkbox" name="numbers" checked> Números</label>
        <!-- Checkbox opcional para incluir símbolos -->
        <label><input type="checkbox" name="symbols"> Símbolos</label>
        <br><br>

        <!-- Botón que envía el formulario para generar la contraseña -->
        <button type="submit" name="generar">Generar contraseña</button>
    </form>
</body>
</html>