<?php
session_start();
require_once '../configuracion/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../iniciar_sesion.php');
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: listar_usuarios.php');
    exit;
}

$error = '';
$mensaje = '';

// Obtener datos actuales
$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = :id");
$stmt->execute(['id' => $id]);
$usuario = $stmt->fetch();

if (!$usuario) {
    header('Location: listar_usuarios.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = filter_input(INPUT_POST, 'nombre_usuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $rol = $_POST['rol'];
    $nueva_contrasena = $_POST['contrasena'];

    if ($nombre_usuario && $correo && $rol) {
        try {
            if (!empty($nueva_contrasena)) {
                // Actualizar con contraseña
                $hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
                $sql = "UPDATE usuarios SET usuario = :usuario, email = :email, rol = :rol, clave = :clave WHERE id = :id";
                $params = [
                    'usuario' => $nombre_usuario,
                    'email' => $correo,
                    'rol' => $rol,
                    'clave' => $hash,
                    'id' => $id
                ];
            } else {
                // Actualizar sin contraseña
                $sql = "UPDATE usuarios SET usuario = :usuario, email = :email, rol = :rol WHERE id = :id";
                $params = [
                    'usuario' => $nombre_usuario,
                    'email' => $correo,
                    'rol' => $rol,
                    'id' => $id
                ];
            }

            $update = $conexion->prepare($sql);
            $update->execute($params);
            
            // Actualizar variable usuario para mostrar datos nuevos
            $usuario['usuario'] = $nombre_usuario;
            $usuario['email'] = $correo;
            $usuario['rol'] = $rol;
            
            $mensaje = 'Usuario actualizado correctamente.';
        } catch (PDOException $e) {
            $error = 'Error al actualizar: ' . $e->getMessage();
        }
    } else {
        $error = 'Campos obligatorios incompletos.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - EDUIAIO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../recursos/estilos/estilos.css">
</head>

<body>
    <div class="contenedor">
        <div class="cabecera-lista">
            <div>
                <h1 class="titulo-lista">Editar Usuario</h1>
                <p class="subtitulo-lista">Modificando usuario: #<?= $usuario['id'] ?></p>
            </div>
            <div class="acciones-cabecera">
                <a href="listar_usuarios.php" class="btn btn-volver">Volver al Listado</a>
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
                    <label class="etiqueta-formulario" for="nombre_usuario">Nombre de Usuario</label>
                    <input type="text" id="nombre_usuario" name="nombre_usuario" class="control-formulario" 
                        value="<?= htmlspecialchars($usuario['usuario']) ?>" required>
                </div>

                <div class="grupo-formulario">
                    <label class="etiqueta-formulario" for="correo">Correo Electrónico</label>
                    <input type="email" id="correo" name="correo" class="control-formulario" 
                        value="<?= htmlspecialchars($usuario['email']) ?>" required>
                </div>

                <div class="grupo-formulario">
                    <label class="etiqueta-formulario" for="contrasena">Nueva Contraseña (Dejar en blanco para mantener actual)</label>
                    <input type="password" id="contrasena" name="contrasena" class="control-formulario" placeholder="••••••••">
                </div>

                <div class="grupo-formulario">
                    <label class="etiqueta-formulario" for="rol">Rol</label>
                    <select id="rol" name="rol" class="control-formulario">
                        <option value="estudiante" <?= $usuario['rol'] == 'estudiante' ? 'selected' : '' ?>>Estudiante</option>
                        <option value="profesor" <?= $usuario['rol'] == 'profesor' ? 'selected' : '' ?>>Profesor</option>
                        <option value="admin" <?= $usuario['rol'] == 'admin' ? 'selected' : '' ?>>Administrador</option>
                    </select>
                </div>

                <div class="acciones-formulario" style="margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primario">Actualizar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
