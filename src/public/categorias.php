<?php 
// 1. Conexión a AWS RDS
include '../config/db.php'; 

// 2. Obtener la categoría seleccionada (si existe)
$categoria_id = isset($_GET['id']) ? intval($_GET['id']) : null;

// 3. Consulta para listar las categorías y el conteo de juegos (GROUP BY)
$sql_menu = "SELECT c.id, c.nombre, COUNT(v.id) as total 
             FROM categorias c 
             LEFT JOIN videojuegos v ON c.id = v.categoria_id 
             GROUP BY c.id, c.nombre";
$res_menu = $conn->query($sql_menu);

// 4. Si hay una categoría seleccionada, buscamos esos juegos (JOIN)
$juegos_filtrados = null;
if ($categoria_id) {
    $sql_filtro = "SELECT titulo, precio FROM videojuegos WHERE categoria_id = $categoria_id";
    $juegos_filtrados = $conn->query($sql_filtro);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Horizonte Gaming | Filtro por Categorías</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Rajdhani:wght@500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --fondo: #0b0e14;
            --tarjeta: rgba(23, 28, 41, 0.9);
            --neon-v: #a855f7;
            --neon-c: #22d3ee;
        }

        body { 
            font-family: 'Rajdhani', sans-serif; 
            margin: 0; 
            background: linear-gradient(rgba(11, 14, 20, 0.9), rgba(11, 14, 20, 0.9)), 
                        url('https://images.unsplash.com/photo-1550745165-9bc0b252726f?q=80&w=2070&auto=format&fit=crop'); 
            background-size: cover; background-attachment: fixed; color: #e2e8f0;
        }

        header {
            background: rgba(0, 0, 0, 0.95); border-bottom: 3px solid var(--neon-v);
            padding: 1rem 0; text-align: center;
        }

        .header-container { max-width: 1200px; margin: auto; display: flex; justify-content: space-between; align-items: center; padding: 0 30px; }
        .logo { font-family: 'Orbitron', sans-serif; color: var(--neon-c); text-decoration: none; font-size: 1.5rem; text-shadow: 0 0 10px var(--neon-c); }

        nav a { color: #fff; text-decoration: none; margin-left: 20px; font-weight: 700; text-transform: uppercase; }

        main { max-width: 1000px; margin: 40px auto; padding: 30px; display: grid; grid-template-columns: 300px 1fr; gap: 30px; }

        /* Panel Lateral de Categorías */
        .sidebar { background: var(--tarjeta); padding: 20px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1); height: fit-content; }
        .cat-item { 
            display: flex; justify-content: space-between; padding: 12px; margin-bottom: 10px;
            background: rgba(255,255,255,0.03); border-radius: 10px; text-decoration: none; color: #fff;
            transition: 0.3s; border: 1px solid transparent;
        }
        .cat-item:hover, .cat-item.active { border-color: var(--neon-c); background: rgba(34, 211, 238, 0.1); transform: scale(1.02); }

        /* Resultados del Filtro */
        .results-container { background: var(--tarjeta); padding: 25px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1); }
        .game-card { 
            padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); 
            display: flex; justify-content: space-between; align-items: center;
        }
        .price { color: #22c55e; font-family: 'Orbitron', sans-serif; font-weight: 700; }
        
        .empty-state { text-align: center; padding: 50px; color: #64748b; font-style: italic; }
    </style>
</head>
<body>

<header>
    <div class="header-container">
        <a href="index.php" class="logo">HORIZONTE GAMING</a>
        <nav>
            <a href="index.php">Panel</a>
            <a href="crear.php">Añadir</a>
            <a href="categorias.php">Categorías</a>
        </nav>
    </div>
</header>

<main>
    <aside class="sidebar">
        <h3 style="font-family: 'Orbitron'; color: var(--neon-v);">FILTRAR</h3>
        <a href="categorias.php" class="cat-item <?php echo !$categoria_id ? 'active' : ''; ?>">
            <span>Ver Todo</span>
        </a>
        <?php while($cat = $res_menu->fetch_assoc()): ?>
            <a href="categorias.php?id=<?php echo $cat['id']; ?>" 
               class="cat-item <?php echo ($categoria_id == $cat['id']) ? 'active' : ''; ?>">
                <span><?php echo htmlspecialchars($cat['nombre']); ?></span>
                <span style="color: var(--neon-c); font-weight: bold;"><?php echo $cat['total']; ?></span>
            </a>
        <?php endwhile; ?>
    </aside>

    <section class="results-container">
        <h2 style="font-family: 'Orbitron'; margin-top: 0;">
            <?php echo $categoria_id ? "Resultados del Filtro" : "Selecciona una categoría"; ?>
        </h2>

        <?php if ($juegos_filtrados && $juegos_filtrados->num_rows > 0): ?>
            <?php while($juego = $juegos_filtrados->fetch_assoc()): ?>
                <div class="game-card">
                    <div>
                        <span style="font-size: 1.2rem; font-weight: 700; color: #fff;"><?php echo htmlspecialchars($juego['titulo']); ?></span>
                    </div>
                    <span class="price"><?php echo number_format($juego['precio'], 2); ?> €</span>
                </div>
            <?php endwhile; ?>
        <?php elseif ($categoria_id): ?>
            <div class="empty-state">No hay juegos registrados en esta categoría todavía.</div>
        <?php else: ?>
            <div class="empty-state">Haz clic en una categoría de la izquierda para ver los títulos disponibles en Amazon RDS.</div>
        <?php endif; ?>
    </section>
</main>

</body>
</html>