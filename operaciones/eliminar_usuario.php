<?php
/**
 * operaciones/eliminar_usuario.php
 *
 * Elimina un usuario de la base de datos y redirige al listado.
 * Medida de seguridad: un administrador no puede eliminarse a sí mismo.
 */

session_start();
require_once '../configuracion/conexion.php';
require_once '../includes/auth.php';

// Solo usuarios logueados pueden eliminar otros usuarios
requerir_sesion('../iniciar_sesion.php');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    // Impedir auto-eliminación
    if ($id == $_SESSION['id_usuario']) {
        echo "<script>alert('No puedes eliminar tu propio usuario.'); window.location.href='listar_usuarios.php';</script>";
        exit;
    }

    try {
        $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->execute(['id' => $id]);
    } catch (PDOException $e) {
        // Probable error de integridad referencial (usuario con cursos asignados)
        echo "<script>alert('Error: Es posible que este usuario tenga cursos asociados.'); window.location.href='listar_usuarios.php';</script>";
        exit;
    }
}

header('Location: listar_usuarios.php');
exit;
