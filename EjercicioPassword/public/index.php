<form action="procesa.php" method="POST">

    <label>Longitud:</label>
    <input type="number" name="longitud" required><br><br>

    <label><input type="checkbox" name="mayus"> Mayúsculas</label><br>
    <label><input type="checkbox" name="minus"> Minúsculas</label><br>
    <label><input type="checkbox" name="nums"> Números</label><br>
    <label><input type="checkbox" name="simbolos"> Símbolos</label><br><br>

    <button type="submit">Generar contraseña</button>
</form>
