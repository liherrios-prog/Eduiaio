<?php
session_start();

// Si el usuario ya está logueado, ir al Panel
if (isset($_SESSION['id_usuario'])) {
    header('Location: panel.php');
    exit;
}

// Si no, mostrar la landing page
header('Location: landing_page.php');
exit;
?>