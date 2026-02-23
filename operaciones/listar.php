<?php
/**
 * operaciones/listar.php
 *
 * Lista todos los cursos de la plataforma en una tabla.
 * Acceso restringido: solo usuarios con sesión activa (admin/profesor).
 */

session_start();
require_once '../configuracion/conexion.php';
require_once '../includes/auth.php';

// Solo usuarios logueados pueden gestionar cursos
requerir_sesion('../iniciar_sesion.php');

// ── Obtener todos los cursos con datos relacionados ───────────────────
// JOIN con categorías (FK) y usuarios (creador del curso)
$consulta = $conexion->query("
    SELECT
        cursos.*,
        categorias.nombre AS nombre_categoria,
        usuarios.usuario  AS instructor
    FROM cursos
    LEFT JOIN categorias ON cursos.categoria_id = categorias.id
    LEFT JOIN usuarios   ON cursos.creado_por   = usuarios.id
    ORDER BY cursos.fecha_creacion DESC
");
$cursos = $consulta->fetchAll();

// ── Variables para el fragmento <head> ───────────────────────────────
$titulo_pagina = 'Gestión de Cursos';
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
                <h1 class="titulo-lista">Lista de Cursos</h1>
                <p class="subtitulo-lista">Administra la oferta educativa</p>
            </div>
            <div class="acciones-cabecera">
                <a href="../panel.php" class="btn btn-claro" style="margin-right: 0.5rem;">
                    ← Volver al Panel
                </a>
                <a href="crear.php" class="btn btn-primario">+ Nuevo Curso</a>
            </div>
        </div>

        <!-- ── Tabla de cursos ────────────────────────────────── -->
        <div class="tarjeta contenedor-tabla">
            <table class="tabla-base" id="tabla-cursos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Curso</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Creado Por</th>
                        <th class="td-derecha">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cursos as $curso): ?>
                        <tr class="fila-tabla">
                            <td style="font-weight: 500;">#<?= $curso['id'] ?></td>

                            <td class="celda-curso">
                                <div class="titulo-curso">
                                    <?= htmlspecialchars($curso['titulo'], ENT_QUOTES, 'UTF-8') ?>
                                </div>
                                <small class="descripcion-curso">
                                    <?= htmlspecialchars(substr($curso['descripcion'], 0, 50), ENT_QUOTES, 'UTF-8') ?>...
                                </small>
                            </td>

                            <td>
                                <span class="badge-categoria">
                                    <?= htmlspecialchars($curso['nombre_categoria'] ?? 'Sin Categoría', ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </td>

                            <td class="precio-curso">
                                <?= number_format($curso['precio'], 2) ?> €
                            </td>

                            <td style="color: var(--texto-secundario);">
                                <?= htmlspecialchars($curso['instructor'] ?? 'Sistema', ENT_QUOTES, 'UTF-8') ?>
                            </td>

                            <td class="td-derecha">
                                <a href="editar.php?id=<?= $curso['id'] ?>" class="btn btn-texto-primario">
                                    Editar
                                </a>
                                <a href="eliminar.php?id=<?= $curso['id'] ?>"
                                   class="btn btn-texto-peligro"
                                   onclick="return confirm('¿Seguro que quieres eliminar este curso?');">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Mensaje si no hay cursos -->
            <?php if (empty($cursos)): ?>
                <div class="mensaje-vacio">
                    No hay cursos registrados. ¡Crea el primero!
                </div>
            <?php endif; ?>
        </div>

    </div>
    <!-- Scripts: jQuery y DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tabla-cursos').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
                },
                "order": [[0, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": 5 }
                ],
                "pageLength": 10,
                "responsive": true
            });
        });
    </script>
</body>

</html>