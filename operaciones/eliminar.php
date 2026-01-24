<?php
session_start();
require_once '../configuracion/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../iniciar_sesion.php');
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    $consulta = $conexion->prepare("DELETE FROM courses WHERE id = ?");
    $consulta->execute([$id]);
}

header('Location: listar.php');
exit;
?>