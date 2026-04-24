--Tabla de CATEGORÍAS
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

--Tabla de DESARROLLADORES
CREATE TABLE IF NOT EXISTS desarrolladores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    pais VARCHAR(50)
);

--Tabla de VIDEOJUEGOS
CREATE TABLE IF NOT EXISTS videojuegos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    precio DECIMAL(10,2) DEFAULT 0.00,
    categoria_id INT,
    desarrollador_id INT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL,
    FOREIGN KEY (desarrollador_id) REFERENCES desarrolladores(id) ON DELETE SET NULL
);

--Tabla de USUARIOS
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) NOT NULL
);

--Tabla de LOGS 
CREATE TABLE IF NOT EXISTS logs_actividad (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(255),
    fecha DATETIME
);



DELIMITER //
CREATE PROCEDURE sp_insertar_juego(IN p_titulo VARCHAR(100), IN p_precio DECIMAL(10,2))
BEGIN
    INSERT INTO videojuegos (titulo, precio) VALUES (p_titulo, p_precio);
END //
DELIMITER ;


DELIMITER //
CREATE FUNCTION fn_precio_con_iva(precio DECIMAL(10,2)) 
RETURNS DECIMAL(10,2)
DETERMINISTIC
BEGIN
    RETURN precio * 1.21;
END //
DELIMITER ;


CREATE TRIGGER tg_despues_usuario_nuevo
AFTER INSERT ON usuarios
FOR EACH ROW
INSERT INTO logs_actividad (descripcion, fecha) 
VALUES (CONCAT('Se ha registrado el usuario: ', NEW.username), NOW());


INSERT INTO categorias (nombre) VALUES ('Acción'), ('RPG'), ('Aventura');
INSERT INTO desarrolladores (nombre, pais) VALUES ('Nintendo', 'Japón'), ('Ubisoft', 'Francia');