<?php 
include '../config/db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    
    $sql = "INSERT INTO videojuegos (titulo, precio) VALUES ('$titulo', '$precio')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "❌ Error al guardar: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Juego</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f4f4f4; }
        form { background: white; padding: 20px; border-radius: 8px; max-width: 400px; margin: auto; }
        input { width: 100%; padding: 10px; margin: 10px 0; display: block; box-sizing: border-box; }
        button { background: #007bff; color: white; border: none; padding: 10px; width: 100%; cursor: pointer; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">🎮 Añadir Nuevo Videojuego</h2>
    <form method="POST">
        <input type="text" name="titulo" placeholder="Título del juego" required>
        <input type="text" name="genero" placeholder="Género (Ej: RPG, Acción)" required>
        <input type="number" step="0.01" name="precio" placeholder="Precio (Ej: 59.99)" required>
        <button type="submit">Guardar en AWS</button>
        <br><br>
        <a href="index.php">Volver atrás</a>
    </form>
</body>
</html>