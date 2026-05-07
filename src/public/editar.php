<?php

require_once '../config/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    
    $stmt_busqueda = $conexion->prepare("SELECT * FROM videojuegos WHERE id = ?");
    $stmt_busqueda->bind_param("i", $id);
    $stmt_busqueda->execute();
    $resultado = $stmt_busqueda->get_result();
    $producto = $resultado->fetch_assoc();

    if (!$producto) {
        die("Videojuego no encontrado.");
    }
} else {
    die("ID no válido.");
}

// 3. Obtener categorías para el desplegable
$res_cats = $conexion->query("SELECT * FROM categorias");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $stock  = $_POST['stock'];
    $cat_id = $_POST['categoria_id'];

    // Consulta segura 
    $sql_update = "UPDATE videojuegos SET titulo = ?, precio = ?, stock = ?, categoria_id = ? WHERE id = ?";
    $stmt_update = $conexion->prepare($sql_update);
    $stmt_update->bind_param("sdiii", $titulo, $precio, $stock, $cat_id, $id);

    if ($stmt_update->execute()) {
        // Redige al index al terminar
        header("Location: index.php?msg=actualizado");
        exit();
    } else {
        $error_msg = "Error al actualizar: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto - Horizonte Gaming</title>
    <style>
        :root {
            --neon-purple: #9d4edd;
            --neon-blue: #00d4ff;
            --dark-bg: #0f0f1b;
            --card-bg: #1a1a2e;
            --text: #e0e0e0;
        }

        body {
            background-color: var(--dark-bg);
            color: var(--text);
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background: var(--card-bg);
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5), 0 0 10px var(--neon-purple);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            color: var(--neon-blue);
            text-transform: uppercase;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid var(--neon-purple);
            padding-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: var(--neon-purple);
            font-size: 0.9rem;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 1.2rem;
            border-radius: 8px;
            border: 1px solid #333;
            background: #0b0b16;
            color: white;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: var(--neon-blue);
            box-shadow: 0 0 8px var(--neon-blue);
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        button {
            background: linear-gradient(45deg, var(--neon-purple), var(--neon-blue));
            border: none;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
            transition: 0.3s;
        }

        button:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px var(--neon-blue);
        }

        .btn-cancelar {
            color: #ff4d4d;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .btn-cancelar:hover {
            text-shadow: 0 0 8px #ff4d4d;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Editar Videojuego</h1>
    
    <?php if(isset($error_msg)) echo "<p style='color:red'>$error_msg</p>"; ?>

    <form method="POST">
        <label>Título del Juego:</label>
        <input type="text" name="titulo" value="<?php echo htmlspecialchars($producto['titulo']); ?>" required>

        <label>Precio (€):</label>
        <input type="number" step="0.01" name="precio" value="<?php echo $producto['precio']; ?>" required>

        <label>Stock Disponible:</label>
        <input type="number" name="stock" value="<?php echo $producto['stock']; ?>" required>

        <label>Categoría:</label>
        <select name="categoria_id" required>
            <?php while($cat = $res_cats->fetch_assoc()): ?>
                <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $producto['categoria_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($cat['nombre']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <div class="buttons">
            <button type="submit">Guardar Cambios</button>
            <a href="index.php" class="btn-cancelar">Cancelar</a>
        </div>
    </form>
</div>

</body>
</html>