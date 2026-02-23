<?php
/**
 * operaciones/eliminar.php
 *
 * Elimina un curso de la base de datos y redirige al listado.
 * Acción destructiva — se confirma con un dialog de JavaScript antes de llamar a esta URL.
 */

session_start();
require_once '../configuracion/conexion.php';
require_once '../includes/auth.php';

// Solo usuarios logueados pueden eliminar cursos
requerir_sesion('../iniciar_sesion.php');

// ── Validar y ejecutar la eliminación ─────────────────────────────────
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    // La BD eliminará las relaciones en cascada si están configuradas
    $consulta = $conexion->prepare("DELETE FROM cursos WHERE id = ?");
    $consulta->execute([$id]);
}

// Redirigir siempre al listado (con o sin éxito)
header('Location: listar.php');
exit;