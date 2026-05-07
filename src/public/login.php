<?php
session_start();
include '../config/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['usuario'];
    $pass = $_POST['password'];

    // Buscar el usuario
    $stmt = $conexion->prepare("SELECT id, password FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($fila = $resultado->fetch_assoc()) {
        if ($pass === $fila['password']) { 
            $_SESSION['usuario'] = $user;
            header("Location: index.php");
            exit();
        } else {
            $error = "Acceso denegado: Contraseña incorrecta";
        }
    } else {
        $error = "Acceso denegado: Usuario no registrado";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Horizonte Gaming | Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Rajdhani:wght@500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Rajdhani', sans-serif; background: #0b0e14; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; color: white; }
        .login-box { background: #1a1f2e; padding: 40px; border-radius: 15px; border: 2px solid #a855f7; box-shadow: 0 0 20px rgba(168, 85, 247, 0.4); width: 320px; text-align: center; }
        h2 { font-family: 'Orbitron'; color: #22d3ee; margin-bottom: 25px; }
        input { width: 100%; padding: 12px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #444; background: #0b0e14; color: white; box-sizing: border-box; }
        button { width: 100%; padding: 12px; border-radius: 5px; border: none; background: linear-gradient(90deg, #a855f7, #22d3ee); color: white; font-weight: bold; cursor: pointer; text-transform: uppercase; }
        .error { color: #ff4655; font-size: 14px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>LOGIN</h2>
        <?php if($error) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
            <div class="links" style="margin-top: 15px; font-size: 14px;">
    ¿No tienes cuenta? <a href="registro.php" style="color: #a855f7; text-decoration: none;">Regístrate aquí</a>
</div>
        </form>
    </div>
</body>
</html>