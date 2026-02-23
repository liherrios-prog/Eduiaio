<?php
/**
 * operaciones/editar_categoria.php
 *
 * Formulario para editar una categoría existente.
 */

session_start();
require_once '../configuracion/conexion.php';
require_once '../includes/auth.php';

// Verificar sesión activa
requerir_sesion('../iniciar_sesion.php');

// ── Validar ID de la categoría pasado por URL ──────────────────────────
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: listar_categorias.php');
    exit;
}

// Obtener los datos actuales de la categoría
$consulta = $conexion->prepare("SELECT * FROM categorias WHERE id = ?");
$consulta->execute([$id]);
$categoria = $consulta->fetch();

if (!$categoria) {
    header('Location: listar_categorias.php');
    exit;
}

$error = '';
$mensaje = '';

// ── Procesamiento del formulario de edición ────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING));
    $descripcion = trim(filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING));

    if ($nombre) {
        // Verificar si el nombre ya existe (excluyendo la categoría actual)
        $check = $conexion->prepare("SELECT id FROM categorias WHERE nombre = :nombre AND id != :id");
        $check->execute(['nombre' => $nombre, 'id' => $id]);
        
        if ($check->rowCount() > 0) {
            $error = "La categoría '$nombre' ya existe.";
        } else {
            try {
                $stmt = $conexion->prepare("UPDATE categorias SET nombre = :nombre, descripcion = :descripcion WHERE id = :id");
                $stmt->execute(['nombre' => $nombre, 'descripcion' => $descripcion, 'id' => $id]);
                $mensaje = "Categoría actualizada exitosamente.";
                
                // Recargar los datos
                $consulta = $conexion->prepare("SELECT * FROM categorias WHERE id = ?");
                $consulta->execute([$id]);
                $categoria = $consulta->fetch();
            } catch (PDOException $e) {
                $error = "Error al actualizar la categoría: " . $e->getMessage();
            }
        }
    } else {
        $error = "El nombre es obligatorio.";
    }
}

// ── Variables para el fragmento <head> ────────────────────────────────
$titulo_pagina = 'Editar Categoría';
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
        <div class="cabecera-lista">
            <div>
                <h1 class="titulo-lista">Editar Categoría</h1>
                <p class="subtitulo-lista">Modifica la categoría existente</p>
            </div>
            <div class="acciones-cabecera">
                <a href="listar_categorias.php" class="btn btn-volver">Volver al Listado</a>
            </div>
        </div>

        <div class="tarjeta" style="max-width: 600px; margin: 0 auto;">
            <?php if ($error): ?>
                <div class="alerta-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if ($mensaje): ?>
                <div class="alerta-exito" style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                    <?= htmlspecialchars($mensaje) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="grupo-formulario">
                    <label class="etiqueta-formulario" for="nombre">Nombre de la Categoría</label>
                    <input type="text" id="nombre" name="nombre" class="control-formulario" 
                           value="<?= htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8') ?>" required>
                </div>

                <div class="grupo-formulario">
                    <label class="etiqueta-formulario" for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion" class="control-formulario" rows="3"><?= htmlspecialchars($categoria['descripcion'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>

                <div class="acciones-formulario" style="margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primario">Guardar Cambios</button>
                    <a href="listar_categorias.php" class="btn btn-secundario">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
