<?php
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