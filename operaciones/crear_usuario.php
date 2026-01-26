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
    $nombre_usuario = filter_input(INPUT_POST, 'nombre_usuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];

    if ($nombre_usuario && $correo && $contrasena && $rol) {
        $hash_contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

        try {
            // Verificar duplicados
            $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE usuario = :usuario OR email = :email");
            $stmt->execute(['usuario' => $nombre_usuario, 'email' => $correo]);

            if ($stmt->rowCount() > 0) {
                $error = 'El usuario o correo ya existen.';
            } else {
                $insertar = $conexion->prepare("INSERT INTO usuarios (usuario, email, clave, rol) VALUES (:usuario, :email, :clave, :rol)");
                $insertar->execute([
                    'usuario' => $nombre_usuario,
                    'email' => $correo,
                    'clave' => $hash_contrasena,
                    'rol' => $rol
                ]);
                $mensaje = 'Usuario creado exitosamente.';
            }
        } catch (PDOException $e) {
            $error = 'Error al crear usuario: ' . $e->getMessage();
        }
    } else {
        $error = 'Todos los campos son obligatorios.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Usuario - EDUIAIO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../recursos/estilos/estilos.css">
</head>

<body>
    <div class="contenedor">
        <div class="cabecera-lista">
            <div>
                <h1 class="titulo-lista">Crear Usuario</h1>
                <p class="subtitulo-lista">Añadir un nuevo usuario al sistema</p>
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
                    <input type="text" id="nombre_usuario" name="nombre_usuario" class="control-formulario" required>
                </div>

                <div class="grupo-formulario">
                    <label class="etiqueta-formulario" for="correo">Correo Electrónico</label>
                    <input type="email" id="correo" name="correo" class="control-formulario" required>
                </div>

                <div class="grupo-formulario">
                    <label class="etiqueta-formulario" for="contrasena">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" class="control-formulario" required>
                </div>

                <div class="grupo-formulario">
                    <label class="etiqueta-formulario" for="rol">Rol</label>
                    <select id="rol" name="rol" class="control-formulario">
                        <option value="estudiante">Estudiante</option>
                        <option value="profesor">Profesor</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>

                <div class="acciones-formulario" style="margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primario">Crear Usuario</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
