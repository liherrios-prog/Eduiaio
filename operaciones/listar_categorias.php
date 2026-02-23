<?php
/**
 * operaciones/listar_categorias.php
 *
 * Lista todas las categorías de la plataforma en una tabla.
 * Permite crear, editar y eliminar categorías.
 * Acceso restringido: solo usuarios con sesión activa (admin).
 */

session_start();
require_once '../configuracion/conexion.php';
require_once '../includes/auth.php';

// Solo usuarios logueados pueden gestionar categorías
requerir_sesion('../iniciar_sesion.php');

// ── Obtener todas las categorías ordenadas ──────────────────────────
$consulta = $conexion->query("SELECT * FROM categorias ORDER BY nombre ASC");
$categorias = $consulta->fetchAll();

// ── Variables para el fragmento <head> ────────────────────────────────
$titulo_pagina = 'Gestión de Categorías';
$css_href      = '../recursos/estilos/estilos.css';
$ruta_raiz     = '../';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include '../vistas/fragmentos/head.php'; ?>
</head>

<body>

    <!-- Barra de navegación del admin -->
    <?php include '../vistas/fragmentos/nav_admin.php'; ?>

    <div class="contenedor">

        <!-- ── Cabecera de la sección ─────────────────────────── -->
        <div class="cabecera-lista">
            <div>
                <h1 class="titulo-lista">Gestión de Categorías</h1>
                <p class="subtitulo-lista">Organiza los cursos por categorías</p>
            </div>
            <div class="acciones-cabecera">
                <a href="../panel.php" class="btn btn-claro" style="margin-right: 0.5rem;">
                    ← Volver al Panel
                </a>
                <a href="crear_categoria.php" class="btn btn-primario">+ Nueva Categoría</a>
            </div>
        </div>

        <!-- ── Tabla de categorías ───────────────────────────── -->
        <div class="tarjeta contenedor-tabla">
            <table class="tabla-base" id="tabla-categorias">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th class="td-derecha">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categorias as $categoria): ?>
                        <tr class="fila-tabla">
                            <td style="font-weight: 500;">#<?= $categoria['id'] ?></td>

                            <td>
                                <div class="titulo-curso">
                                    <?= htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8') ?>
                                </div>
                            </td>

                            <td class="descripcion-curso">
                                <?= htmlspecialchars(substr($categoria['descripcion'] ?? '', 0, 60), ENT_QUOTES, 'UTF-8') ?>
                                <?php if (strlen($categoria['descripcion'] ?? '') > 60): ?>...<?php endif; ?>
                            </td>

                            <td class="td-derecha">
                                <a href="editar_categoria.php?id=<?= $categoria['id'] ?>" class="btn btn-texto-primario">
                                    Editar
                                </a>
                                <a href="eliminar_categoria.php?id=<?= $categoria['id'] ?>"
                                   class="btn btn-texto-peligro"
                                   onclick="return confirm('¿Seguro que quieres eliminar esta categoría?');">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Mensaje si no hay categorías -->
            <?php if (empty($categorias)): ?>
                <div class="mensaje-vacio">
                    No hay categorías registradas. ¡Crea la primera!
                </div>
            <?php endif; ?>
        </div>

    </div>

    <!-- Scripts: jQuery y DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tabla-categorias').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
                },
                "order": [[0, "asc"]],
                "columnDefs": [
                    { "orderable": false, "targets": 3 }
                ],
                "pageLength": 10,
                "responsive": true
            });
        });
    </script>
</body>

</html>
