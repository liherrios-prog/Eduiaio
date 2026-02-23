<?php
/**
 * vistas/fragmentos/nav_admin.php
 *
 * Barra de navegación superior del panel de administración.
 *
 * Variables esperadas:
 *   $_SESSION['nombre_usuario']  — nombre del usuario logueado.
 *
 * Uso:
 *   include ROOT . '/vistas/fragmentos/nav_admin.php';
 */
?>
<header class="cabecera-navegacion">
    <div class="contenedor contenido-navegacion">

        <!-- Logo / nombre de la aplicación -->
        <h2 class="titulo-panel">
            EDUIAIO <span>Admin Panel</span>
        </h2>

        <!-- Info del usuario y cierre de sesión -->
        <div class="info-usuario">
            <span>Hola, <strong><?= htmlspecialchars($_SESSION['nombre_usuario']) ?></strong></span>
            <a href="<?= $ruta_raiz ?? '../' ?>cerrar_sesion.php"
               class="btn btn-peligro texto-pequeno">
                Cerrar Sesión
            </a>
        </div>

    </div>
</header>
