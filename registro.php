<?php
session_start();
require_once 'configuracion/conexion.php';

$error = '';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = filter_input(INPUT_POST, 'nombre_usuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    // Validaciones básicas
    if (!$nombre_usuario || !$correo || !$contrasena || !$confirmar_contrasena) {
        $error = 'Por favor complete todos los campos.';
    } elseif ($contrasena !== $confirmar_contrasena) {
        $error = 'Las contraseñas no coinciden.';
    } else {
        // Verificar si el usuario o correo ya existen
        $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE usuario = :usuario OR email = :email");
        $stmt->execute(['usuario' => $nombre_usuario, 'email' => $correo]);
        
        if ($stmt->rowCount() > 0) {
            $error = 'El nombre de usuario o correo ya están registrados.';
        } else {
            // Crear nuevo usuario estudiante
            $hash_contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
            $rol = 'estudiante';

            try {
                $insertar = $conexion->prepare("INSERT INTO usuarios (usuario, email, clave, rol) VALUES (:usuario, :email, :clave, :rol)");
                $insertar->execute([
                    'usuario' => $nombre_usuario,
                    'email' => $correo,
                    'clave' => $hash_contrasena,
                    'rol' => $rol
                ]);

                // Redirigir al login con mensaje de éxito (o iniciar sesión directamente, pero por seguridad mejor login)
                // Para simplificar, mostramos mensaje y link al login
                $mensaje = '¡Registro exitoso! Ahora puedes iniciar sesión.';
            } catch (PDOException $e) {
                $error = 'Error al registrar el usuario: ' . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - EDUIAIO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="recursos/estilos/estilos.css">
</head>

<body>
    <div class="contenedor-login">
        <div class="tarjeta-login" style="max-width: 450px;">
            <div class="cabecera-login">
                <h1>EDUIAIO</h1>
                <p>Crear nueva cuenta de Estudiante</p>
            </div>

            <?php if ($error): ?>
                <div class="alerta-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if ($mensaje): ?>
                <div class="alerta-exito" style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; text-align: center;">
                    <?= htmlspecialchars($mensaje) ?>
                    <br>
                    <a href="iniciar_sesion.php" style="font-weight: 600; color: var(--color-primario); text-decoration: none; display: block; margin-top: 0.5rem;">Ir a Iniciar Sesión</a>
                </div>
            <?php else: ?>

            <form method="POST" action="">
                <div class="grupo-formulario">
                    <label class="etiqueta-formulario" for="nombre_usuario">Nombre de Usuario</label>
                    <input type="text" id="nombre_usuario" name="nombre_usuario" class="control-formulario"
                        placeholder="ej. juanperez" required value="<?= isset($_POST['nombre_usuario']) ? htmlspecialchars($_POST['nombre_usuario']) : '' ?>">
                </div>

                <div class="grupo-formulario">
                    <label class="etiqueta-formulario" for="correo">Correo Electrónico</label>
                    <input type="email" id="correo" name="correo" class="control-formulario"
                        placeholder="juan@ejemplo.com" required value="<?= isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : '' ?>">
                </div>

                <div class="grupo-formulario">
                    <label class="etiqueta-formulario" for="contrasena">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" class="control-formulario"
                        placeholder="••••••••" required>
                </div>

                <div class="grupo-formulario">
                    <label class="etiqueta-formulario" for="confirmar_contrasena">Confirmar Contraseña</label>
                    <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" class="control-formulario"
                        placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primario btn-login">
                    Registrarse
                </button>
            </form>
            
            <div class="pie-login" style="text-align: center; margin-top: 1.5rem;">
                <p style="color: var(--texto-secundario);">¿Ya tienes cuenta? <a href="iniciar_sesion.php" style="color: var(--color-primario); text-decoration: none; font-weight: 500;">Inicia Sesión</a></p>
            </div>

            <?php endif; ?>
        </div>
    </div>
</body>

</html>
