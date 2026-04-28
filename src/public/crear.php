<?php 
include '../config/db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];

    // Insertamos solo título y precio para asegurar que funcione
    $sql = "INSERT INTO videojuegos (titulo, precio) VALUES ('$titulo', '$precio')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php"); // Si sale bien, nos manda al inicio
        exit();
    } else {
        echo "<h2 style='color:red'>❌ Error al guardar: " . $conn->error . "</h2>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Juego</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 40px; }
        form { background: white; padding: 20px; border-radius: 8px; max-width: 300px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input { width: 100%; padding: 8px; margin: 10px 0; display: block; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <form method="POST">
        <h3>Añadir Videojuego</h3>
        <input type="text" name="titulo" placeholder="Nombre del juego" required>
        <input type="number" step="0.01" name="precio" placeholder="Precio (ej: 59.99)" required>
        <button type="submit">Guardar en Amazon RDS</button>
        <br>
        <a href="index.php" style="display:block; text-align:center; margin-top:10px;">Volver</a>
    </form>
</body>
</html>