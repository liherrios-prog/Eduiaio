<?php
session_start();
require_once '../configuracion/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../iniciar_sesion.php');
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: listar.php');
    exit;
}

// Obtener Categorías (FK)
$categorias = $conexion->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();

// Obtener Curso Actual
$consulta = $conexion->prepare("SELECT * FROM courses WHERE id = ?");
$consulta->execute([$id]);
$curso = $consulta->fetch();

if (!$curso) {
    die("Curso no encontrado.");
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_SPECIAL_CHARS);
    $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
    $id_categoria = filter_input(INPUT_POST, 'id_categoria', FILTER_VALIDATE_INT);

    if ($titulo && $precio !== false && $id_categoria) {
        $consultaActualizar = $conexion->prepare("UPDATE courses SET title=?, description=?, price=?, category_id=? WHERE id=?");
        $consultaActualizar->execute([$titulo, $descripcion, $precio, $id_categoria, $id]);

        // El Trigger 'after_course_update' se ejecuta automáticamente aquí

        header('Location: listar.php');
        exit;
    } else {
        $error = "Datos inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Curso - EDUIAIO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../recursos/estilos/estilos.css">
</head>

<body>
    <div class="contenedor" style="max-width: 800px;">
        <div class="tarjeta">
            <h2>Editar Curso:
                <?= htmlspecialchars($curso['title']) ?>
            </h2>

            <?php if ($error): ?>
                <div style="background: #FEE2E2; color: #991B1B; padding: 1rem; margin-bottom: 1rem;">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="grupo-formulario">
                    <label class="etiqueta-formulario">Título</label>
                    <input type="text" name="titulo" value="<?= htmlspecialchars($curso['title']) ?>"
                        class="control-formulario" required>
                </div>

                <div class="grupo-formulario">
                    <label class="etiqueta-formulario">Descripción</label>
                    <textarea name="descripcion" class="control-formulario"
                        rows="3"><?= htmlspecialchars($curso['description']) ?></textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="grupo-formulario">
                        <label class="etiqueta-formulario">Precio (€)</label>
                        <input type="number" step="0.01" name="precio" value="<?= $curso['price'] ?>"
                            class="control-formulario" required>
                    </div>

                    <div class="grupo-formulario">
                        <label class="etiqueta-formulario">Categoría</label>
                        <select name="id_categoria" class="control-formulario" required>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria['id'] ?>" <?= $categoria['id'] == $curso['category_id'] ? 'selected' : '' ?>
                                    >
                                    <?= htmlspecialchars($categoria['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primario">Actualizar Curso</button>
                    <a href="listar.php" class="btn" style="background: #F3F4F6;">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>