<?php

function cargarEnv() {
    $envFile = __DIR__ . '/.env';

    if (!file_exists($envFile)) {
        die("Error: No se encontró el archivo .env");
    }

    $lineas = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lineas as $linea) {

        // Saltar comentarios (#)
        if (str_starts_with(trim($linea), '#')) continue;

        list($clave, $valor) = explode('=', $linea, 2);

        $clave  = trim($clave);
        $valor  = trim($valor);

        $_ENV[$clave] = $valor;
    }
}

function getConexion()
{
    // 1. Cargar variables del .env
    cargarEnv();

    // 2. Leerlas
    $dsn  = $_ENV['BD_DNS'];
    $user = $_ENV['BD_USERNAME'];
    $pass = $_ENV['BD_PASSWORD'];

    // 3. Crear conexión PDO
    try {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;

    } catch (PDOException $e) {
        die("ERROR conexión BD: " . $e->getMessage());
    }
}
