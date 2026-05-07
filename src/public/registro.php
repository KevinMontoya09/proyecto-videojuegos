<?php
include '../config/db.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['usuario'];
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    if ($pass !== $confirm_pass) {
        $mensaje = "<p style='color: #ff4655;'>Las contraseñas no coinciden.</p>";
    } else {
        // Verificar si el usuario ya existe
        $check = $conexion->prepare("SELECT id FROM usuarios WHERE usuario = ?");
        $check->bind_param("s", $user);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $mensaje = "<p style='color: #ff4655;'>El nombre de usuario ya está pillado.</p>";
        } else {
            // Insertar nuevo usuario
            $stmt = $conn->prepare("INSERT INTO usuarios (usuario, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $user, $pass);
            
            if ($stmt->execute()) {
                $mensaje = "<p style='color: #22d3ee;'>¡Cuenta creada! Ya puedes entrar.</p>";
            } else {
                $mensaje = "<p style='color: #ff4655;'>Error al registrar. Inténtalo de nuevo.</p>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Horizonte Gaming | Registro</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Rajdhani:wght@500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Rajdhani', sans-serif; background: #0b0e14; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; color: white; }
        .register-box { background: #1a1f2e; padding: 40px; border-radius: 15px; border: 2px solid #22d3ee; box-shadow: 0 0 20px rgba(34, 211, 238, 0.3); width: 350px; text-align: center; }
        h2 { font-family: 'Orbitron'; color: #a855f7; margin-bottom: 20px; }
        input { width: 100%; padding: 12px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #444; background: #0b0e14; color: white; box-sizing: border-box; }
        button { width: 100%; padding: 12px; border-radius: 5px; border: none; background: linear-gradient(90deg, #22d3ee, #a855f7); color: white; font-weight: bold; cursor: pointer; text-transform: uppercase; }
        .links { margin-top: 20px; font-size: 14px; }
        a { color: #22d3ee; text-decoration: none; }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>NUEVA CUENTA</h2>
        <?php echo $mensaje; ?>
        <form method="POST">
            <input type="text" name="usuario" placeholder="Elige un Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="password" name="confirm_password" placeholder="Repite Contraseña" required>
            <button type="submit">Registrarse</button>
        </form>
        <div class="links">
            ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
        </div>
    </div>
</body>
</html>
 
