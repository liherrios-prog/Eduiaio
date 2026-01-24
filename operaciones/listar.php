<?php
session_start();
require_once '../configuracion/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../iniciar_sesion.php');
    exit;
}

// Obtener Cursos con Nombre de Categoría usando JOIN
$consulta = $conexion->query("
    SELECT courses.*, categories.name as nombre_categoria, users.username as instructor
    FROM courses 
    LEFT JOIN categories ON courses.category_id = categories.id
    LEFT JOIN users ON courses.created_by = users.id
    ORDER BY courses.created_at DESC
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
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h1 style="margin: 0;">Lista de Cursos</h1>
                <p style="color: var(--texto-secundario);">Administra la oferta educativa</p>
            </div>
            <div style="display: flex; gap: 1rem;">
                <a href="../panel.php" class="btn" style="background: white; border: 1px solid #D1D5DB;">Volver al
                    Panel</a>
                <a href="crear.php" class="btn btn-primario">+ Nuevo Curso</a>
            </div>
        </div>

        <!-- Tarjeta con Tabla -->
        <div class="tarjeta" style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; border-bottom: 2px solid #F3F4F6;">
                        <th style="padding: 1rem; color: var(--texto-secundario);">ID</th>
                        <th style="padding: 1rem; color: var(--texto-secundario);">Curso</th>
                        <th style="padding: 1rem; color: var(--texto-secundario);">Categoría</th>
                        <th style="padding: 1rem; color: var(--texto-secundario);">Precio</th>
                        <th style="padding: 1rem; color: var(--texto-secundario);">Creado Por</th>
                        <th style="padding: 1rem; color: var(--texto-secundario); text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cursos as $curso): ?>
                        <tr style="border-bottom: 1px solid #F3F4F6;">
                            <td style="padding: 1rem; font-weight: 500;">#
                                <?= $curso['id'] ?>
                            </td>
                            <td style="padding: 1rem;">
                                <div style="font-weight: 600;">
                                    <?= htmlspecialchars($curso['title']) ?>
                                </div>
                                <small style="color: var(--texto-secundario);">
                                    <?= htmlspecialchars(substr($curso['description'], 0, 50)) ?>...
                                </small>
                            </td>
                            <td style="padding: 1rem;">
                                <span
                                    style="background: #EEF2FF; color: var(--color-primario); padding: 0.25rem 0.5rem; border-radius: 999px; font-size: 0.75rem; font-weight: 600;">
                                    <?= htmlspecialchars($curso['nombre_categoria'] ?? 'Sin Categoría') ?>
                                </span>
                            </td>
                            <td style="padding: 1rem; font-weight: 600;">
                                <?= number_format($curso['price'], 2) ?> €
                            </td>
                            <td style="padding: 1rem; color: var(--texto-secundario);">
                                <?= htmlspecialchars($curso['instructor'] ?? 'Sistema') ?>
                            </td>
                            <td style="padding: 1rem; text-align: right;">
                                <a href="editar.php?id=<?= $curso['id'] ?>" class="btn"
                                    style="color: var(--color-primario); padding: 0.25rem 0.5rem; margin-right: 0.5rem;">Editar</a>
                                <a href="eliminar.php?id=<?= $curso['id'] ?>" class="btn"
                                    style="color: var(--color-peligro); padding: 0.25rem 0.5rem;"
                                    onclick="return confirm('¿Estás seguro de eliminar este curso?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if (empty($cursos)): ?>
                <div style="text-align: center; padding: 2rem; color: var(--texto-secundario);">
                    No hay cursos registrados. ¡Crea el primero!
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>