<?php
// Configuración de la Base de Datos
$servidor = 'localhost';
$nombre_bd = 'eduiaio';
$usuario = 'root';
$contrasena = ''; // XAMPP por defecto es vacío

try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$nombre_bd;charset=utf8mb4", $usuario, $contrasena);
    // Forzar el uso de utf8mb4 en todas las consultas
    $conexion->exec("SET NAMES utf8mb4");

    // Configurar PDO para lanzar excepciones en caso de error
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Establecer modo de obtención predeterminado a array asociativo
    $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>