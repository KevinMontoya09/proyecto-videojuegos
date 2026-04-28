<?php 

include '../config/db.php'; 


$sql = "SELECT * FROM videojuegos";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Colección de Videojuegos</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 20px; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #333; color: white; }
        .btn-instalar { background: #28a745; color: white; padding: 10px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>🎮 Panel de Videojuegos (AWS RDS)</h1>
    
    <div style="margin-bottom: 20px;">
        <a href="instalar.php" class="btn-instalar">⚙️ Re-instalar Base de Datos</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>                
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado->num_rows > 0): ?>
                <?php while($fila = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $fila['id']; ?></td>
                        <td><?php echo $fila['titulo']; ?></td>                        
                        <td><?php echo $fila['precio']; ?>€</td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay juegos en la base de datos. ¡Añade algunos desde HeidiSQL!</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>