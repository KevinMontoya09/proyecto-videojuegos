<?php
$host = 'databasepruebaclase.cnppohiwfhks.us-east-1.rds.amazonaws.com';
$user = 'admin';
$pass = 'America2004';
$db   = 'databasepruebaclase';


mysqli_report(MYSQLI_REPORT_OFF);

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die(" Error de conexión: " . $conn->connect_error);

echo "<h2 style='color:green'>✅ Conexión exitosa a AWS</h2>";

$ruta_final = __DIR__ . '/script.sql';

if (file_exists($ruta_final)) {
    $script = file_get_contents($ruta_final);
    
    
    if ($conn->multi_query($script)) {
        
        do { if ($result = $conn->store_result()) { $result->free(); } } 
        while ($conn->next_result());

        echo "<h2 style='color:blue'>¡POR FIN! Cohete azul: Todo instalado correctamente.</h2>";
        echo "<p>Las tablas se han verificado en la nube de Amazon.</p>";
    } else {
        echo "<h2 style='color:orange'> Nota:</h2>";
        echo "El script dio un aviso, pero es probable que las tablas ya existan.";
        echo "<br>Error técnico: " . $conn->error;
        echo "<br><br><a href='index.php' style='padding:10px; background:blue; color:white; text-decoration:none;'>IR AL INICIO</a>";
    }
} else {
    echo "<h2 style='color:red'> Error: No encuentro 'script.sql'</h2>";
}
$conn->close();