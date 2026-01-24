<?php
session_start();

// Si el usuario ya está logueado, ir al Panel
if (isset($_SESSION['id_usuario'])) {
    header('Location: panel.php');
    exit;
}

// Si no, ir al Inicio de Sesión
header('Location: iniciar_sesion.php');
exit;
?>