<?php
session_start();
require_once '../configuracion/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../iniciar_sesion.php');
    exit;
}

$error = '';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING));
    $descripcion = trim(filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING));

    if ($nombre) {
        try {
            // Verificar si ya existe
            $check = $conexion->prepare("SELECT id FROM categorias WHERE nombre = :nombre");
            $check->execute(['nombre' => $nombre]);
            
            if ($check->rowCount() > 0) {
                $error = "La categoría '$nombre' ya existe.";
            } else {
                $stmt = $conexion->prepare("INSERT INTO categorias (nombre, descripcion) VALUES (:nombre, :descripcion)");
                $stmt->execute(['nombre' => $nombre, 'descripcion' => $descripcion]);
                $mensaje = "Categoría creada exitosamente.";
            }
        } catch (PDOException $e) {
            $error = "Error al crear la categoría: " . $e->getMessage();
        }
    } else {
        $error = "El nombre es obligatorio.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Categoría - EDUIAIO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../recursos/estilos/estilos.css">
</head>

<body>
    <div class="contenedor">
        <div class="cabecera-lista">
            <div>
                <h1 class="titulo-lista">Nueva Categoría</h1>
                <p class="subtitulo-lista">Añadir una nueva categoría de cursos</p>
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
                    <input type="text" id="nombre" name="nombre" class="control-formulario" required>
                </div>

                <div class="grupo-formulario">
                    <label class="etiqueta-formulario" for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion" class="control-formulario" rows="3"></textarea>
                </div>

                <div class="acciones-formulario" style="margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primario">Guardar Categoría</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
