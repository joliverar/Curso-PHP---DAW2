<?php
declare(strict_types=1);

namespace App\Helpers;

use App\Clases\ConexionBD;

/**
 * Funciones simples para manejar libros (sin patrón MVC).
 * Las funciones están en el namespace Oscar\Ejercicio2\Helpers
 * y usan la clase ConexionBD (autocargada por Composer).
 */

/**
 * Inserta un libro. Devuelve true si se insertó correctamente.
 *
 * @param array{titulo:string, anyo_edicion:int, precio:string, fecha_adquisicion:string} $data
 */
function insertarLibro(array $data): bool
{
    $pdo = ConexionBD::getConexion();
    $sql = 'INSERT INTO libros (titulo, anyo_edicion, precio, fecha_adquisicion) VALUES (:titulo, :anyo_edicion, :precio, :fecha_adquisicion)';
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':titulo' => $data['titulo'],
        ':anyo_edicion' => $data['anyo_edicion'],
        ':precio' => $data['precio'],
        ':fecha_adquisicion' => $data['fecha_adquisicion'],
    ]);
}

/**
 * Recupera todos los libros ordenados por número de ejemplar.
 *
 * @return array<int, array<string,mixed>>
 */
function obtenerLibros(): array
{
    $pdo = ConexionBD::getConexion();
    $sql = 'SELECT numero_ejemplar, titulo, anyo_edicion, precio, fecha_adquisicion FROM libros ORDER BY numero_ejemplar';
    return $pdo->query($sql)->fetchAll();
}