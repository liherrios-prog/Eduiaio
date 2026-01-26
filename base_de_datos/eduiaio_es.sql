-- Eliminación y Creación de la Base de Datos
DROP DATABASE IF EXISTS eduiaio;
CREATE DATABASE eduiaio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE eduiaio;

-- Tabla: usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    clave VARCHAR(255) NOT NULL, -- Almacenará el hash de la contraseña
    rol ENUM('admin', 'estudiante', 'profesor') DEFAULT 'estudiante',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla: categorias
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT
);

-- Tabla: cursos
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

-- Tabla: auditoria
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
-- Usuario Admin (Contraseña: password)
INSERT INTO usuarios (usuario, email, clave, rol) VALUES 
('admin', 'admin@eduiaio.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Categorías adaptadas al público objetivo (Personas mayores/Jubilados)
INSERT INTO categorias (nombre, descripcion) VALUES 
('Iniciación Digital', 'Primeros pasos con ordenadores, tablets y móviles'),
('Comunicación y Redes', 'WhatsApp, Videollamadas y Redes Sociales para conectar con la familia'),
('Trámites y Gestiones', 'Banca online, Citas médicas y Administración electrónica'),
('Ocio y Bienestar', 'Fotografía, Viajes, Memoria y Entretenimiento digital'),
('Seguridad Digital', 'Uso seguro de internet y prevención de estafas');

-- Cursos de ejemplo adaptados
INSERT INTO cursos (titulo, descripcion, precio, categoria_id, creado_por) VALUES 
('Uso Básico del Teléfono Móvil', 'Aprende a llamar, guardar contactos y usar la cámara sin miedo', 25.00, 1, 1),
('WhatsApp para Mantener el Contacto', 'Envía fotos, audios y haz videollamadas con tus nietos y amigos', 20.00, 2, 1),
('Pierde el Miedo al Ordenador', 'Curso de iniciación desde cero: Ratón, teclado y navegación web', 30.00, 1, 1),
('Banca Online Segura', 'Aprende a consultar tu saldo y hacer transferencias con seguridad', 35.00, 3, 1),
('Salud y Citas Médicas Online', 'Gestiona tus citas y recetas desde el móvil o el ordenador', 15.00, 3, 1),
('Descubre YouTube y la Música Online', 'Entretenimiento, tutoriales y música a tu alcance', 15.00, 4, 1);
