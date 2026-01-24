-- Creación de la Base de Datos
CREATE DATABASE IF NOT EXISTS eduiaio;
USE eduiaio;

-- Tabla: users (Para el Sistema de Login)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Almacenará el hash de la contraseña
    role ENUM('admin', 'student', 'teacher') DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla: categories (Origen de las FK)
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
);

-- Tabla: courses (Entidad Principal del CRUD)
CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) DEFAULT 0.00,
    category_id INT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Tabla: audit_logs (Para el Trigger de Auditoría)
CREATE TABLE IF NOT EXISTS audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    table_name VARCHAR(50),
    action VARCHAR(50),
    record_id INT,
    details TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Trigger: Registrar Actualizaciones de Cursos
DELIMITER //
CREATE TRIGGER after_course_update
AFTER UPDATE ON courses
FOR EACH ROW
BEGIN
    INSERT INTO audit_logs (table_name, action, record_id, details)
    VALUES ('courses', 'UPDATE', OLD.id, CONCAT('Precio cambiado de ', OLD.price, ' a ', NEW.price));
END;
//
DELIMITER ;

-- Insertar Datos Por Defecto
INSERT INTO users (username, email, password, role) VALUES 
('admin', 'admin@eduiaio.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'); -- contraseña: password

INSERT INTO categories (name, description) VALUES 
('Desarrollo Web', 'Frontend, Backend y Fullstack'),
('Data Science', 'IA, Machine Learning y Big Data'),
('Marketing', 'Marketing Digital y SEO');

INSERT INTO courses (title, description, price, category_id, created_by) VALUES 
('Master en PHP Moderno', 'Aprende Laravel y Symfony desde cero', 49.99, 1, 1),
('Bootcamp de React', 'Hooks, Context y Redux', 59.99, 1, 1),
('Introducción a Python', 'Python para ciencia de datos', 39.99, 2, 1);
