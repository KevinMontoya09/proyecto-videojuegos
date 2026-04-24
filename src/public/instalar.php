<?php
$host = 'databasepruebaclase.cnppohiwfhks.us-east-1.rds.amazonaws.com';
$user = 'admin';
$pass = 'America2004';
$db   = 'databasepruebaclase';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("❌ Error de conexión");

echo "<h2 style='color:green'>✅ Conexión exitosa a AWS</h2>";

$ruta1 = __DIR__ . '/../db/script.sql';
$ruta2 = __DIR__ . '/../../db/script.sql';
$ruta3 = '/var/www/html/db/script.sql';

if (file_exists($ruta1)) {
    $ruta_final = $ruta1;
} elseif (file_exists($ruta2)) {
    $ruta_final = $ruta2;
} else {
    die("<h2 style='color:orange'>⚠️ El archivo script.sql no aparece.</h2> 
         Asegúrate de que dentro de la carpeta <b>db</b> haya un archivo llamado exactamente <b>script.sql</b>");
}

$script = file_get_contents($ruta_final);

if ($conn->multi_query($script)) {
    echo "<h2 style='color:blue'>🚀 ¡TODO LISTO! Tablas creadas. Ya puedes empezar el proyecto.</h2>";
} else {
    echo "❌ Error al ejecutar SQL: " . $conn->error;
}
$conn->close();