<?php
/**
 * operaciones/crear.php
 *
 * Formulario para crear un nuevo curso.
 * Carga las categorías disponibles para el desplegable (FK).
 */

session_start();
require_once '../configuracion/conexion.php';
require_once '../includes/auth.php';

// Solo administradores/profesores pueden crear cursos
requerir_sesion('../iniciar_sesion.php');

// ── Cargar categorías para el SELECT ─────────────────────────────────
$consulta  = $conexion->query("SELECT * FROM categorias ORDER BY nombre ASC");
$categorias = $consulta->fetchAll();

$error = '';

// ── Procesamiento del formulario ──────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo      = trim(filter_input(INPUT_POST, 'titulo',      FILTER_SANITIZE_STRING));
    $descripcion = trim(filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING));
    $precio      = filter_input(INPUT_POST, 'precio',      FILTER_VALIDATE_FLOAT);
    $id_categoria = filter_input(INPUT_POST, 'id_categoria', FILTER_VALIDATE_INT);

    if ($titulo && $precio !== false && $id_categoria) {
        try {
            // Insertar el nuevo curso; el trigger de auditoría se ejecuta automáticamente
            $consulta = $conexion->prepare(
                "INSERT INTO cursos (titulo, descripcion, precio, categoria_id, creado_por)
                 VALUES (?, ?, ?, ?, ?)"
            );
            $consulta->execute([$titulo, $descripcion, $precio, $id_categoria, $_SESSION['id_usuario']]);

            header('Location: listar.php');
            exit;
        } catch (PDOException $e) {
            $error = 'Error al guardar el curso. Inténtalo de nuevo.';
        }
    } else {
        $error = 'El título, precio y categoría son obligatorios.';
    }
}

// ── Variables para el fragmento <head> ───────────────────────────────
$titulo_pagina = 'Nuevo Curso';
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
            <h2 class="margen-sup-0 margen-inf-1-5">Añadir Nuevo Curso</h2>

            <!-- Mensaje de error -->
            <?php if ($error): ?>
                <div class="alerta-error"><?= $error ?></div>
            <?php endif; ?>

            <!-- Formulario de creación -->
            <form method="POST">

                <div class="grupo-formulario">
                    <label class="etiqueta-formulario">Título del Curso</label>
                    <input type="text" name="titulo" class="control-formulario"
                           placeholder="Ej: Iniciación al Móvil" required>
                </div>

                <div class="grupo-formulario">
                    <label class="etiqueta-formulario">Descripción</label>
                    <textarea name="descripcion" class="control-formulario" rows="3"
                              placeholder="Detalles del contenido del curso..."></textarea>
                </div>

                <div class="grid-2-col">
                    <div class="grupo-formulario">
                        <label class="etiqueta-formulario">Precio (€)</label>
                        <input type="number" step="0.01" name="precio" class="control-formulario"
                               placeholder="0.00" required>
                    </div>

                    <div class="grupo-formulario">
                        <label class="etiqueta-formulario">Categoría</label>
                        <select name="id_categoria" class="control-formulario" required>
                            <option value="">Seleccione una categoría...</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria['id'] ?>">
                                    <?= htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="botones-accion">
                    <button type="submit" class="btn btn-primario">Guardar Curso</button>
                    <a href="listar.php" class="btn btn-secundario">Cancelar</a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>