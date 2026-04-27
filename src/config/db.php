<?php

$host = 'databasepruebaclase.cnppohiwfhks.us-east-1.rds.amazonaws.com';
$user = 'admin';
$pass = 'America2004';
$db   = 'databasepruebaclase';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(" Error de conexión a AWS: " . $conn->connect_error);
}
// Esto es para que los acentos y la 'ñ' salgan bien
$conn->set_charset("utf8");
?>