<?php
$cad = "Programación";

echo "La cadena \$cad con posiciones ".strlen($cad)."</br>";

echo "La cadena \$cad con posiciones reales ".mb_strlen($cad);

$nombre = "jino";

echo "<p>".strtoupper($nombre)."</p>";

$texto = " La programación es muy divertida ";

echo  trim($texto)."</br>";
echo ltrim($texto)."</br>";
echo rtrim($texto)."</br>";

$a = "El futbol";
$b = "El baloncesto";


$frace = "$a es bonito";
echo $frace."</br>";
echo str_replace($a, $b, $frace)."</br>";

$colores = ["rojo", "azul", "verde", "negro", "blanco"];

foreach($colores as $color){
    echo $color."<br>";
}
echo "<p> Los colores </p>";
foreach($colores as $i => $color){
    echo ($i+1). "="."$color"."</br>";
}


$persona = [
    "Nombre"=>"Jino",
    "Edad"=>"34",
    "Ciudad"=>"Lima"
];


echo "<p> Nombre: ".$persona["Nombre"]."</p>";
echo "<p> Edad: ".$persona["Edad"]."</p>";
echo "<p> Ciudad: ".$persona["Ciudad"]."</p>";

$frutas = ["lima", "mandarina", "naranaja"];

echo count($frutas);


array_push($frutas, "fresa");


echo "<pre>";
print_r($frutas);
echo "</pre>";

array_pop($frutas);

echo "<pre>";
print_r($frutas);
echo "</pre>";

$nums = [10,20,30,40,50];

if(in_array(10, $nums)){
    echo "<p>$nums[0] esta en el array</p>";
}

unset($nums[3]);

print_r($nums);


$clases = [
   "DAW" => ["Programación", "Entornos"],
"DAM" =>[ "Sistemas", "BasesDatos"]
];
foreach($clases as $ciclo => $asignatura){
    echo "<p>La asignatura de $ciclo es: ".$asignatura[0]."</p>";
}


?>

