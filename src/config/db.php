<?php


function mi_log_personalizado($mensaje) {
    $archivo = 'debug.log'; 
    $fecha = date("Y-m-d H:i:s");
    $linea = "[" . $fecha . "] ACCIÓN: " . $mensaje . PHP_EOL;
    
   
    file_put_contents($archivo, $linea, FILE_APPEND);
}


mi_log_personalizado("El usuario visitó la página principal de Horizonte Gaming");

$host = 'databasepruebaclase.cnppohiwfhks.us-east-1.rds.amazonaws.com';
$user = 'admin';
$pass = 'America2004';
$db   = 'databasepruebaclase';

//Conexion con el servidor
$conexion = new mysqli($host, $user, $pass, $db);


if ($conexion->connect_error) {
    die(" Error de conexión a AWS: " . $conexion->connect_error);
}


$conexion->set_charset("utf8");
?>