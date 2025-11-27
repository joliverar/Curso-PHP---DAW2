<?php
require_once "conexionBD.php";

function getEquipos()
{
    $pdo = getConexion();

    $sql = "SELECT nombre FROM equipos";
    $stmt = $pdo->query($sql);

    // Devuelve un array con SOLO el nombre
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function getJugadores(){
    $pdo = getConexion();
    $sql = "select nombre, procedencia, altura from jugadores";
    $stmt = $pdo->query($sql);
    return $stmt -> fetchAll(PDO::FETCH_COLUMN);
}

function probarFetchModes()
{
    $pdo = getConexion();

    $sql = "SELECT nombre FROM equipos LIMIT 3";

    echo "<h3>FETCH_ASSOC</h3>";
    $stmt = $pdo->query($sql);
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

    echo "<h3>FETCH_OBJ</h3>";
    $stmt = $pdo->query($sql);
    print_r($stmt->fetchAll(PDO::FETCH_OBJ));

    echo "<h3>FETCH_NUM</h3>";
    $stmt = $pdo->query($sql);
    print_r($stmt->fetchAll(PDO::FETCH_NUM));
}
