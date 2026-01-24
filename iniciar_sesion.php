<?php
session_start();
require_once 'configuracion/conexion.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $contrasena = $_POST['contrasena'];

    if ($correo && $contrasena) {
        // Consultar usuario
        $consulta = $conexion->prepare("SELECT id, usuario, clave, rol FROM usuarios WHERE email = :correo");
        $consulta->execute(['correo' => $correo]);
        $usuario = $consulta->fetch();

        if ($usuario && password_verify($contrasena, $usuario['clave'])) {
            // Inicio de sesión exitoso
            $_SESSION['id_usuario'] = $usuario['id'];
            $_SESSION['nombre_usuario'] = $usuario['usuario'];
            $_SESSION['rol'] = $usuario['rol'];

            header('Location: panel.php');
            exit;
        } else {
            $error = 'Credenciales inválidas.';
        }
    } else {
        $error = 'Por favor complete todos los campos.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - EDUIAIO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="recursos/estilos/estilos.css">
</head>

<body>
    <div class="contenedor-login">
        <div class="tarjeta-login">
            <div class="cabecera-login">
                <h1>EDUIAIO</h1>
                <p style="color: #6B7280;">Bienvenido de nuevo</p>
            </div>

            <?php if ($error): ?>
                <div
                    style="background: #FEE2E2; color: #991B1B; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; text-align: center;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="grupo-formulario">
                    <label class="etiqueta-formulario" for="correo">Correo Electrónico</label>
                    <input type="email" id="correo" name="correo" class="control-formulario"
                        placeholder="admin@eduiaio.com" required>
                </div>

                <div class="grupo-formulario">
                    <label class="etiqueta-formulario" for="contrasena">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" class="control-formulario"
                        placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primario" style="width: 100%; padding: 0.75rem; font-size: 1rem;">
                    Iniciar Sesión
                </button>
            </form>

            <div style="margin-top: 1.5rem; text-align: center; font-size: 0.875rem; color: #6B7280;">
                <p>Credenciales Demo:</p>
                <code>admin@eduiaio.com / password</code>
            </div>
        </div>
    </div>
</body>

</html>