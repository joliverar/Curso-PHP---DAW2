<?php
/*
 * contador_llamadas.php
 * - Cuenta cuántas veces se llamó a una función usando una variable 'static'.
 * - Una variable static conserva su valor entre invocaciones en la MISMA petición.
 */

function contarLlamadas() {
    static $veces = 0; // se inicializa una sola vez; persiste en siguientes llamadas
    $veces++;
    return $veces;
}

// Demostración: llamamos varias veces en la misma ejecución
echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>contador_llamadas</title></head><body>";
echo "Llamada 1: " . contarLlamadas() . "<br>";
echo "Llamada 2: " . contarLlamadas() . "<br>";
echo "Llamada 3: " . contarLlamadas() . "<br>";
echo "</body></html>";
