<?php
session_start();
require_once '../configuracion/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../iniciar_sesion.php');
    exit;
}

// Obtener Cursos con Nombre de Categoría usando JOIN
$consulta = $conexion->query("
    SELECT cursos.*, categorias.nombre as nombre_categoria, usuarios.usuario as instructor
    FROM cursos 
    LEFT JOIN categorias ON cursos.categoria_id = categorias.id
    LEFT JOIN usuarios ON cursos.creado_por = usuarios.id
    ORDER BY cursos.fecha_creacion DESC
");
$cursos = $consulta->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Cursos - EDUIAIO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../recursos/estilos/estilos.css">
</head>

<body>
    <div class="contenedor">
        <!-- Cabecera -->
        <div class="cabecera-lista">
            <div>
                <h1 class="titulo-lista">Lista de Cursos</h1>
                <p class="subtitulo-lista">Administra la oferta educativa</p>
            </div>
            <div class="acciones-cabecera">
                <a href="../panel.php" class="btn btn-volver">Volver al Panel</a>
                <a href="crear_categoria.php" class="btn btn-claro" style="margin-right: 0.5rem;">+ Nueva Categoría</a>
                <a href="crear.php" class="btn btn-primario">+ Nuevo Curso</a>
            </div>
        </div>

        <!-- Tarjeta con Tabla -->
        <div class="tarjeta contenedor-tabla">
            <table class="tabla-base">
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
                            <td style="font-weight: 500;">#
                                <?= $curso['id'] ?>
                            </td>
                            <td class="celda-curso">
                                <div class="titulo-curso">
                                    <?= htmlspecialchars($curso['titulo']) ?>
                                </div>
                                <small class="descripcion-curso">
                                    <?= htmlspecialchars(substr($curso['descripcion'], 0, 50)) ?>...
                                </small>
                            </td>
                            <td>
                                <span class="badge-categoria">
                                    <?= htmlspecialchars($curso['nombre_categoria'] ?? 'Sin Categoría') ?>
                                </span>
                            </td>
                            <td class="precio-curso">
                                <?= number_format($curso['precio'], 2) ?> €
                            </td>
                            <td style="color: var(--texto-secundario);">
                                <?= htmlspecialchars($curso['instructor'] ?? 'Sistema') ?>
                            </td>
                            <td class="td-derecha">
                                <a href="editar.php?id=<?= $curso['id'] ?>" class="btn btn-texto-primario">Editar</a>
                                <a href="eliminar.php?id=<?= $curso['id'] ?>" class="btn btn-texto-peligro"
                                    onclick="return confirm('¿Estás seguro de eliminar este curso?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if (empty($cursos)): ?>
                <div class="mensaje-vacio">
                    No hay cursos registrados. ¡Crea el primero!
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>