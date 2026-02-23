<?php
/**
 * operaciones/editar.php
 *
 * Formulario para editar un curso existente.
 * Al guardar, el trigger de auditoría 'despues_actualizacion_curso' se ejecuta automáticamente en la BD.
 */

session_start();
require_once '../configuracion/conexion.php';
require_once '../includes/auth.php';

// Verificar sesión activa
requerir_sesion('../iniciar_sesion.php');

// ── Validar ID del curso pasado por URL ───────────────────────────────
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: listar.php');
    exit;
}

// Cargar categorías para el SELECT (FK)
$categorias = $conexion->query("SELECT * FROM categorias ORDER BY nombre ASC")->fetchAll();

// Obtener los datos actuales del curso
$consulta = $conexion->prepare("SELECT * FROM cursos WHERE id = ?");
$consulta->execute([$id]);
$curso = $consulta->fetch();

if (!$curso) {
    header('Location: listar.php');
    exit;
}

$error = '';

// ── Procesamiento del formulario de edición ───────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo      = trim(filter_input(INPUT_POST, 'titulo',      FILTER_SANITIZE_STRING));
    $descripcion = trim(filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING));
    $precio      = filter_input(INPUT_POST, 'precio',      FILTER_VALIDATE_FLOAT);
    $id_categoria = filter_input(INPUT_POST, 'id_categoria', FILTER_VALIDATE_INT);

    if ($titulo && $precio !== false && $id_categoria) {
        // Actualizar el curso (el trigger de BD registra el cambio automáticamente)
        $consulta = $conexion->prepare(
            "UPDATE cursos SET titulo=?, descripcion=?, precio=?, categoria_id=? WHERE id=?"
        );
        $consulta->execute([$titulo, $descripcion, $precio, $id_categoria, $id]);

        header('Location: listar.php');
        exit;
    } else {
        $error = 'Revisa los campos. Título, precio y categoría son obligatorios.';
    }
}

// ── Variables para el fragmento <head> ───────────────────────────────
$titulo_pagina = 'Editar Curso';
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

    <div class="contenedor contenedor-medio">
        <div class="tarjeta">
            <h2>Editar Curso: <?= htmlspecialchars($curso['titulo'], ENT_QUOTES, 'UTF-8') ?></h2>

            <!-- Mensaje de error -->
            <?php if ($error): ?>
                <div class="alerta-error"><?= $error ?></div>
            <?php endif; ?>

            <!-- Formulario de edición con datos actuales precargados -->
            <form method="POST">

                <div class="grupo-formulario">
                    <label class="etiqueta-formulario">Título</label>
                    <input type="text" name="titulo"
                           value="<?= htmlspecialchars($curso['titulo'], ENT_QUOTES, 'UTF-8') ?>"
                           class="control-formulario" required>
                </div>

                <div class="grupo-formulario">
                    <label class="etiqueta-formulario">Descripción</label>
                    <textarea name="descripcion" class="control-formulario" rows="3">
                        <?= htmlspecialchars($curso['descripcion'], ENT_QUOTES, 'UTF-8') ?>
                    </textarea>
                </div>

                <div class="grid-2-col">
                    <div class="grupo-formulario">
                        <label class="etiqueta-formulario">Precio (€)</label>
                        <input type="number" step="0.01" name="precio"
                               value="<?= $curso['precio'] ?>"
                               class="control-formulario" required>
                    </div>

                    <div class="grupo-formulario">
                        <label class="etiqueta-formulario">Categoría</label>
                        <select name="id_categoria" class="control-formulario" required>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria['id'] ?>"
                                    <?= $categoria['id'] == $curso['categoria_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="botones-accion">
                    <button type="submit" class="btn btn-primario">Actualizar Curso</button>
                    <a href="listar.php" class="btn btn-secundario">Cancelar</a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>