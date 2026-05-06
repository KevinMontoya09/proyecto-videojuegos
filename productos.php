<?php
//conexion y configuracion
require_once '../config/db.php'; 

// consulta con join

$sql = "SELECT v.id, v.titulo, v.precio, v.stock, c.nombre AS categoria_nombre 
        FROM videojuegos v 
        JOIN categorias c ON v.categoria_id = c.id";

$resultado = $conexion->query($sql);

// Error!!
if (!$resultado) {
    die("Error en la consulta: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario - Horizonte Gaming</title>
    <link rel="stylesheet" href="css/estilos.css"> <!-- Para el punto de 'Integra CSS' -->
</head>
<body>
    <h1>Gestión de Inventario - Videojuegos</h1>
    
    <p><a href="crear_producto.php">+ Añadir Nuevo Videojuego</a></p>

    <table border="1">
        <thead>
            <tr>
                <th>Título</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($fila['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($fila['categoria_nombre']); ?></td>
                    <td><?php echo $fila['precio']; ?> €</td>
                    <td><?php echo $fila['stock']; ?> uds</td>
                    <td>
                        <a href="editar.php?id=<?php echo $fila['id']; ?>">Editar</a> | 
                        <a href="borrar.php?id=<?php echo $fila['id']; ?>" onclick="return confirm('¿Seguro?')">Borrar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>