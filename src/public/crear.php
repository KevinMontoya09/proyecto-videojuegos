<?php 
// 1. Conexión a AWS RDS
include '../config/db.php'; 

$mensaje = "";


$sql_cat = "SELECT id, nombre FROM categorias GROUP BY nombre ORDER BY nombre ASC";
$res_categorias = $conexion->query($sql_cat);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST['titulo']);
    $precio = $_POST['precio'];
    $categoria_id = $_POST['categoria_id']; // Recogemos la categoría seleccionada

    if (!empty($titulo) && !empty($precio) && !empty($categoria_id)) {
        
        // Añadimos el campo categoria id a la inserción
        $stmt = $conexion->prepare("INSERT INTO videojuegos (titulo, precio, categoria_id) VALUES (?, ?, ?)");
        
        // "sdi" -> String (titulo), Double (precio), Integer (categoria_id)
        $stmt->bind_param("sdi", $titulo, $precio, $categoria_id);

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: index.php");
            exit();
        } else {
            $mensaje = "<div class='alert error'> Error al guardar en AWS: " . $stmt->error . "</div>";
        }
    } else {
        $mensaje = "<div class='alert warning'> Por favor, completa todos los campos, incluida la categoría.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Juego - Horizonte Gaming</title>
    <style>
        :root {
            --primary: #2c3e50;
            --accent: #3498db;
            --bg: #f8fafc;
        }

        body { 
            font-family: 'Segoe UI', sans-serif; 
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%); 
            margin: 0; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            height: 100vh;
        }

        .card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }

        h2 { text-align: center; color: var(--primary); margin-bottom: 30px; }

        label { display: block; margin-bottom: 8px; font-weight: 600; color: #444; }

        input, select { 
            width: 100%; 
            padding: 12px; 
            margin-bottom: 20px; 
            border: 1px solid #cbd5e1; 
            border-radius: 8px; 
            box-sizing: border-box;
            font-size: 1rem;
        }

        button { 
            width: 100%; 
            padding: 14px; 
            background: var(--accent); 
            color: white; 
            border: none; 
            border-radius: 8px; 
            font-weight: bold; 
            cursor: pointer; 
            transition: 0.3s;
        }

        button:hover { background: #2980b9; }

        .back-link { display: block; text-align: center; margin-top: 20px; color: #64748b; text-decoration: none; }
        .alert { padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
        .error { background: #fee2e2; color: #b91c1c; }
        .warning { background: #fef3c7; color: #92400e; }
    </style>
</head>
<body>

    <div class="card">
        <h2>🎮 Registrar Juego</h2>
        
        <?php echo $mensaje; ?>

        <form method="POST">
            <label>Título</label>
            <input type="text" name="titulo" placeholder="Nombre del juego" required>
            
            <label>Categoría</label>
            <select name="categoria_id" required>
                <option value="">-- Selecciona Categoría --</option>
                <?php while($cat = $res_categorias->fetch_assoc()): ?>
                    <option value="<?php echo $cat['id']; ?>">
                        <?php echo $cat['nombre']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label>Precio (€)</label>
<input type="number" step="0.01" min="0" name="precio" placeholder="0.00" required>
            
            <button type="submit">Guardar en AWS RDS</button>
        </form>

        <a href="index.php" class="back-link">← Cancelar y volver</a>
    </div>

</body>
</html>