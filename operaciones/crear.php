<?php
session_start();
require_once '../configuracion/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../iniciar_sesion.php');
    exit;
}

// Obtener Categorías para Desplegable (FK)
$consulta = $conexion->query("SELECT * FROM categorias ORDER BY nombre ASC");
$categorias = $consulta->fetchAll();

$error = '';
$exito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_SPECIAL_CHARS);
    $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
    $id_categoria = filter_input(INPUT_POST, 'id_categoria', FILTER_VALIDATE_INT);

    if ($titulo && $precio !== false && $id_categoria) {
        try {
            $consulta = $conexion->prepare("INSERT INTO cursos (titulo, descripcion, precio, categoria_id, creado_por) VALUES (?, ?, ?, ?, ?)");
            $consulta->execute([$titulo, $descripcion, $precio, $id_categoria, $_SESSION['id_usuario']]);
            header('Location: listar.php');
            exit;
        } catch (PDOException $e) {
            $error = 'Error al guardar: ' . $e->getMessage();
        }
    } else {
        $error = 'Por favor revise los campos. Todos son obligatorios excepto descripción.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Curso - EDUIAIO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../recursos/estilos/estilos.css">
</head>

<body>
    <div class="contenedor contenedor-medio">
        <div class="tarjeta">
            <h2 class="margen-sup-0 margen-inf-1-5">Añadir Nuevo Curso</h2>

            <?php if ($error): ?>
                <div class="alerta-error">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="grupo-formulario">
                    <label class="etiqueta-formulario">Título del Curso</label>
                    <input type="text" name="titulo" class="control-formulario" placeholder="Ej: Máster en DevOps"
                        required>
                </div>

                <div class="grupo-formulario">
                    <label class="etiqueta-formulario">Descripción</label>
                    <textarea name="descripcion" class="control-formulario" rows="3"
                        placeholder="Detalles del temario..."></textarea>
                </div>

                <div class="grid-2-col">
                    <div class="grupo-formulario">
                        <label class="etiqueta-formulario">Precio (€)</label>
                        <input type="number" step="0.01" name="precio" class="control-formulario" placeholder="0.00"
                            required>
                    </div>

                    <div class="grupo-formulario">
                        <label class="etiqueta-formulario">Categoría (FK)</label>
                        <select name="id_categoria" class="control-formulario" required>
                            <option value="">Seleccione una categoría...</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria['id'] ?>">
                                    <?= htmlspecialchars($categoria['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="color-secundario texto-chico">Este desplegable carga las FK
                            de la
                            tabla 'categorias'</small>
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