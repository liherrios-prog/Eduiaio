-- Eliminación y Creación de la Base de Datos
DROP DATABASE IF EXISTS eduiaio;
CREATE DATABASE eduiaio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE eduiaio;

-- Tabla: usuarios (Antes users)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    clave VARCHAR(255) NOT NULL, -- Almacenará el hash de la contraseña
    rol ENUM('admin', 'estudiante', 'profesor') DEFAULT 'estudiante',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla: categorias (Antes categories)
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT
);

-- Tabla: cursos (Antes courses)
CREATE TABLE IF NOT EXISTS cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) DEFAULT 0.00,
    categoria_id INT,
    creado_por INT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL,
    FOREIGN KEY (creado_por) REFERENCES usuarios(id) ON DELETE SET NULL
);

-- Tabla: auditoria (Antes audit_logs)
CREATE TABLE IF NOT EXISTS auditoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tabla VARCHAR(50),
    accion VARCHAR(50),
    registro_id INT,
    detalles TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Trigger: Registrar Actualizaciones de Cursos
DELIMITER //
CREATE TRIGGER despues_actualizacion_curso
AFTER UPDATE ON cursos
FOR EACH ROW
BEGIN
    INSERT INTO auditoria (tabla, accion, registro_id, detalles)
    VALUES ('cursos', 'ACTUALIZAR', OLD.id, CONCAT('Precio cambiado de ', OLD.precio, ' a ', NEW.precio));
END;
//
DELIMITER ;

-- Insertar Datos Por Defecto
INSERT INTO usuarios (usuario, email, clave, rol) VALUES 
('admin', 'admin@eduiaio.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'); -- contraseña: password

INSERT INTO categorias (nombre, descripcion) VALUES 
('Desarrollo Web', 'Frontend, Backend y Fullstack'),
('Ciencia de Datos', 'IA, Machine Learning y Big Data'),
('Marketing', 'Marketing Digital y SEO');

INSERT INTO cursos (titulo, descripcion, precio, categoria_id, creado_por) VALUES 
('Master en PHP Moderno', 'Aprende Laravel y Symfony desde cero', 49.99, 1, 1),
('Bootcamp de React', 'Hooks, Context y Redux', 59.99, 1, 1),
('Introducción a Python', 'Python para ciencia de datos', 39.99, 2, 1);
