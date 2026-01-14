<?php

function getConexion() {
    $dsn = "mysql:host=localhost;dbname=dwes_01_nba;charset=utf8";
    $user = "root";
    $pass = "";

    try {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}
