<?php
/**
 * operaciones/listar_usuarios.php
 *
 * Lista todos los usuarios del sistema en una tabla.
 * Permite acceder a editar o eliminar cada usuario.
 */

session_start();
require_once '../configuracion/conexion.php';
require_once '../includes/auth.php';
require_once '../includes/funciones.php';

// Solo administradores pueden gestionar usuarios
requerir_sesion('../iniciar_sesion.php');

// ── Obtener todos los usuarios ordenados por fecha de registro ────────
$consulta = $conexion->query("SELECT * FROM usuarios ORDER BY fecha_creacion DESC");
$usuarios = $consulta->fetchAll();

// ── Variables para el fragmento <head> ───────────────────────────────
$titulo_pagina = 'Gestión de Usuarios';
$css_href      = '../recursos/estilos/estilos.css';
$ruta_raiz     = '../';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include '../vistas/fragmentos/head.php'; ?>

    <style>
        /**
         * Badges de rol de usuario.
         * TODO: mover a componentes.css si se necesita en más lugares.
         */
        .badge-rol       { display: inline-block; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; }
        .rol-admin       { background-color: #fee2e2; color: #991b1b; }
        .rol-profesor    { background-color: #fef3c7; color: #92400e; }
        .rol-estudiante  { background-color: #d1fae5; color: #065f46; }
    </style>
</head>

<body>

    <!-- Barra de navegación del admin -->
    <?php include '../vistas/fragmentos/nav_admin.php'; ?>

    <div class="contenedor">

        <!-- ── Cabecera ────────────────────────────────────────── -->
        <div class="cabecera-lista">
            <div>
                <h1 class="titulo-lista">Lista de Usuarios</h1>
                <p class="subtitulo-lista">Administra los usuarios del sistema</p>
            </div>
            <div class="acciones-cabecera">
                <a href="../panel.php" class="btn btn-claro" style="margin-right: 0.5rem;">
                    ← Volver al Panel
                </a>
                <a href="crear_usuario.php" class="btn btn-primario">+ Nuevo Usuario</a>
            </div>
        </div>

        <!-- ── Tabla de usuarios ──────────────────────────────── -->
        <div class="tarjeta contenedor-tabla">
            <table class="tabla-base" id="tabla-usuarios">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Fecha Creación</th>
                        <th class="td-derecha">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr class="fila-tabla">
                            <td style="font-weight: 500;">#<?= $usuario['id'] ?></td>
                            <td><?= htmlspecialchars($usuario['usuario']) ?></td>
                            <td><?= htmlspecialchars($usuario['nombre_completo'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($usuario['email']) ?></td>

                            <!-- Badge de rol con color según tipo -->
                            <td>
                                <span class="badge-rol <?= clase_badge_rol($usuario['rol']) ?>">
                                    <?= ucfirst($usuario['rol']) ?>
                                </span>
                            </td>

                            <td class="texto-secundario">
                                <?= date('d/m/Y', strtotime($usuario['fecha_creacion'])) ?>
                            </td>

                            <td class="td-derecha">
                                <a href="editar_usuario.php?id=<?= $usuario['id'] ?>"
                                   class="btn btn-texto-primario">Editar</a>

                                <!-- No mostrar botón eliminar para el propio usuario logueado -->
                                <?php if ($usuario['id'] != $_SESSION['id_usuario']): ?>
                                    <a href="eliminar_usuario.php?id=<?= $usuario['id'] ?>"
                                       class="btn btn-texto-peligro"
                                       onclick="return confirm('¿Seguro que quieres eliminar este usuario?');">
                                        Eliminar
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Mensaje si no hay usuarios -->
            <?php if (empty($usuarios)): ?>
                <div class="mensaje-vacio">No hay usuarios registrados.</div>
            <?php endif; ?>
        </div>

    </div>

    <!-- Scripts: jQuery y DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tabla-usuarios').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
                },
                "order": [[5, "desc"]], // Ordenar por fecha por defecto
                "columnDefs": [
                    { "orderable": false, "targets": 6 } // No ordenar columna de acciones
                ],
                "pageLength": 10,
                "responsive": true
            });
        });
    </script>
</body>

</html>
