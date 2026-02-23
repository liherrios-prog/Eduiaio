<?php
/**
 * panel.php
 *
 * Panel de control de la aplicación.
 * Redirige al panel correcto según el rol del usuario:
 *   - estudiante → incluye panel_estudiante.php
 *   - admin/profesor → muestra el panel de administración
 */

session_start();
require_once 'includes/auth.php';

// Verificar que existe sesión activa
requerir_sesion('iniciar_sesion.php');

// ── Redirigir a la vista de alumno si corresponde ─────────────────────
if (tiene_rol('estudiante')) {
    include 'panel_estudiante.php';
    exit;
}

// ── Variables para el fragmento <head> (panel admin) ─────────────────
$titulo_pagina = 'Panel Admin';
$css_href      = 'recursos/estilos/estilos.css';
$ruta_raiz     = '';  // estamos en la raíz
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include 'vistas/fragmentos/head.php'; ?>
</head>

<body>

    <!-- Barra de navegación del administrador -->
    <?php include 'vistas/fragmentos/nav_admin.php'; ?>

    <main class="contenedor">

        <!-- ── Tarjetas de estadísticas ───────────────────────── -->
        <div class="cuadricula-estadisticas">
            <div class="tarjeta-estadistica">
                <div class="etiqueta-estadistica">Estado de Conexión</div>
                <div class="valor-estadistica">Activa</div>
            </div>
            <div class="tarjeta-estadistica">
                <div class="etiqueta-estadistica">Rol de Usuario</div>
                <div class="valor-estadistica valor-estadistica-medio">
                    <?= ucfirst($_SESSION['rol']) ?>
                </div>
            </div>
        </div>

        <!-- ── Acceso rápido a gestión de cursos ─────────────── -->
        <div class="tarjeta-accion">
            <h2>Gestión de Cursos</h2>
            <p>Crea, edita y elimina cursos de la plataforma.</p>
            <a href="operaciones/listar.php" class="btn btn-claro">
                Ir al CRUD de Cursos
            </a>
        </div>

        <!-- ── Acceso rápido a gestión de categorías ─────────── -->
        <div class="tarjeta-accion" style="margin-top: 2rem;">
            <h2>Gestión de Categorías</h2>
            <p>Organiza y administra las categorías de cursos. Crea, edita y elimina categorías.</p>
            <a href="operaciones/listar_categorias.php" class="btn btn-claro">
                Ir al CRUD de Categorías
            </a>
        </div>

        <!-- ── Acceso rápido a gestión de usuarios ───────────── -->
        <div class="tarjeta-accion" style="margin-top: 2rem;">
            <h2>Gestión de Usuarios</h2>
            <p>Administra los usuarios de la plataforma: Estudiantes, Profesores y Administradores.</p>
            <a href="operaciones/listar_usuarios.php" class="btn btn-claro">
                Ir al CRUD de Usuarios
            </a>
        </div>

    </main>
</body>

</html>