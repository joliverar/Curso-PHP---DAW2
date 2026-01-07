<?php
require_once "conexionBD.php";

function getLibros()
{
    $pdo = getConexion();

    $sql = "SELECT titulo, precio FROM libros";
    $stmt = $pdo->query($sql);

    // Devuelve un array con SOLO el nombre
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>