<?php 
// 1. Conexión a AWS RDS
include '../config/db.php'; 

// 2. Consulta SQL con JOIN (Para que aparezca el nombre de la categoría)
$sql = "SELECT v.id, v.titulo, v.precio, c.nombre as categoria_nombre 
        FROM videojuegos v
        LEFT JOIN categorias c ON v.categoria_id = c.id
        ORDER BY v.id DESC";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horizonte Gaming | Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Rajdhani:wght@500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --fondo: #0b0e14;
            --tarjeta: rgba(23, 28, 41, 0.85);
            --neon-v: #a855f7;
            --neon-c: #22d3ee;
            --rojo: #ff4655;
        }

        body { 
            font-family: 'Rajdhani', sans-serif; 
            margin: 0; 
            background: linear-gradient(rgba(11, 14, 20, 0.8), rgba(11, 14, 20, 0.8)), 
                        url('https://images.unsplash.com/photo-1511512578047-dfb367046420?q=80&w=2071&auto=format&fit=crop'); 
            background-size: cover;
            background-attachment: fixed;
            color: #e2e8f0;
        }

        header {
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(15px);
            border-bottom: 3px solid var(--neon-v);
            padding: 1rem 0;
            position: sticky; top: 0; z-index: 100;
        }

        .header-container { max-width: 1200px; margin: auto; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        .logo { font-family: 'Orbitron', sans-serif; font-size: 1.5rem; color: var(--neon-c); text-shadow: 0 0 10px var(--neon-c); text-decoration: none; }

        nav ul { list-style: none; display: flex; gap: 20px; padding: 0; }
        nav a { color: #fff; text-decoration: none; font-weight: 700; text-transform: uppercase; }
        nav a:hover { color: var(--neon-v); }

        main { 
            max-width: 1100px; margin: 50px auto; padding: 30px; 
            background: var(--tarjeta); backdrop-filter: blur(20px);
            border-radius: 20px; border: 1px solid rgba(255,255,255,0.1);
        }

        .btn-registro {
            background: linear-gradient(90deg, var(--neon-v), var(--neon-c));
            color: white; padding: 12px 25px; border-radius: 10px;
            text-decoration: none; font-weight: 700; text-transform: uppercase;
            box-shadow: 0 0 15px rgba(168, 85, 247, 0.4);
        }

        table { width: 100%; border-collapse: separate; border-spacing: 0 10px; margin-top: 30px; }
        th { color: #64748b; text-align: left; padding: 10px; text-transform: uppercase; font-size: 0.8rem; }
        td { padding: 20px; background: rgba(255, 255, 255, 0.03); font-size: 1.1rem; }
        td:first-child { border-radius: 10px 0 0 10px; color: var(--neon-v); font-weight: bold; }
        td:last-child { border-radius: 0 10px 10px 0; text-align: right; }

        .badge { background: rgba(34, 211, 238, 0.1); color: var(--neon-c); padding: 5px 10px; border-radius: 5px; border: 1px solid var(--neon-c); font-size: 0.8rem; }
        .precio { color: #22c55e; font-family: 'Orbitron', sans-serif; }
        .eliminar { color: var(--rojo); text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<header>
    <div class="header-container">
        <a href="index.php" class="logo">HORIZONTE GAMING</a>
        <nav>
            <ul>
                <li><a href="index.php">Panel</a></li>
                <li><a href="crear.php">Añadir</a></li>
                <li><a href="categorias.php">Categorías</a></li>
            </ul>
        </nav>
    </div>
</header>

<main>
    <div style="display:flex; justify-content: space-between; align-items:center;">
        <h2 style="font-family: 'Orbitron';">Base de Datos en Vivo</h2>
        <a href="crear.php" class="btn-registro">+ REGISTRAR JUEGO</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>REF</th>
                <th>TÍTULO</th>
                <th>GÉNERO</th>
                <th>PRECIO</th>
                <th>ACCIÓN</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado && $resultado->num_rows > 0): ?>
                <?php while($fila = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $fila['id']; ?></td>
                        <td style="color:white; font-weight:700;"><?php echo htmlspecialchars($fila['titulo']); ?></td>
                        <td><span class="badge"><?php echo $fila['categoria_nombre'] ?? 'GENERAL'; ?></span></td>
                        <td class="precio"><?php echo number_format($fila['precio'], 2); ?> €</td>
                        <td>
                            <a href="borrar.php?id=<?php echo $fila['id']; ?>" class="eliminar" onclick="return confirm('¿Eliminar de AWS?')">[ ELIMINAR ]</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" style="text-align:center;">No hay datos disponibles en Amazon RDS.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

</body>
</html>