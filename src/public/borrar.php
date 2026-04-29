<?php

include '../config/db.php';


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    
    $stmt = $conn->prepare("DELETE FROM videojuegos WHERE id = ?");
    
    
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->close();
        
        header("Location: index.php");
        exit();
    } else {
        echo "❌ Error al intentar borrar en AWS: " . $conn->error;
    }
} else {
    echo "⚠️ ID no válido.";
}
?>