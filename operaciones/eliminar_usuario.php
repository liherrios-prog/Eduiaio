<?php
session_start();
require_once '../configuracion/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../iniciar_sesion.php');
    exit;
}

$id = $_GET['id'] ?? null;

if ($id) {
    if ($id == $_SESSION['id_usuario']) {
        // No permitir auto-eliminación
        echo "<script>alert('No puedes eliminar tu propio usuario.'); window.location.href='listar_usuarios.php';</script>";
        exit;
    }

    try {
        $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->execute(['id' => $id]);
    } catch (PDOException $e) {
        // Error de integridad referencial probable si el usuario tiene cursos asignados
        echo "<script>alert('Error al eliminar: Es posible que este usuario tenga cursos asociados.'); window.location.href='listar_usuarios.php';</script>";
        exit;
    }
}

header('Location: listar_usuarios.php');
exit;
