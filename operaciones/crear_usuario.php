<?php
/**
 * operaciones/crear_usuario.php
 *
 * Formulario para que un administrador cree un nuevo usuario del sistema.
 * Permite asignar rol, datos personales y datos de acceso.
 */

session_start();
require_once '../configuracion/conexion.php';
require_once '../includes/auth.php';

// Solo administradores pueden crear usuarios
requerir_sesion('../iniciar_sesion.php');

$error   = '';
$mensaje = '';

// ── Procesamiento del formulario ──────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = trim($_POST['nombre_usuario'] ?? '');
    $correo         = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $contrasena     = $_POST['contrasena'] ?? '';
    $rol            = $_POST['rol'] ?? '';

    // Validar campos obligatorios
    if (!$nombre_usuario || !$correo || !$contrasena || !$rol) {
        $error = 'Usuario, correo, contraseña y rol son obligatorios.';
    } else {
        try {
            // Comprobar si el usuario o email ya existen
            $stmt = $conexion->prepare(
                "SELECT id FROM usuarios WHERE usuario = :usuario OR email = :email"
            );
            $stmt->execute(['usuario' => $nombre_usuario, 'email' => $correo]);

            if ($stmt->rowCount() > 0) {
                $error = 'El nombre de usuario o correo ya existen.';
            } else {
                // Insertar el nuevo usuario con todos sus datos opcionales
                $insertar = $conexion->prepare("
                    INSERT INTO usuarios
                        (usuario, email, clave, rol, nombre_completo, telefono, direccion, fecha_nacimiento, genero, notas)
                    VALUES
                        (:usuario, :email, :clave, :rol, :nombre_completo, :telefono, :direccion, :fecha_nacimiento, :genero, :notas)
                ");
                $insertar->execute([
                    'usuario'          => $nombre_usuario,
                    'email'            => $correo,
                    'clave'            => password_hash($contrasena, PASSWORD_DEFAULT),
                    'rol'              => $rol,
                    'nombre_completo'  => $_POST['nombre_completo'] ?? null,
                    'telefono'         => $_POST['telefono']        ?? null,
                    'direccion'        => $_POST['direccion']       ?? null,
                    'fecha_nacimiento' => !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null,
                    'genero'           => !empty($_POST['genero'])  ? $_POST['genero'] : null,
                    'notas'            => $_POST['notas']           ?? null,
                ]);

                $mensaje = 'Usuario creado correctamente.';
            }
        } catch (PDOException $e) {
            $error = 'Error al crear el usuario. Inténtalo de nuevo.';
        }
    }
}

// ── Variables para el fragmento <head> ───────────────────────────────
$titulo_pagina = 'Nuevo Usuario';
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

        <!-- Cabecera -->
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

            <!-- Alertas de error o éxito -->
            <?php if ($error): ?>
                <div class="alerta-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($mensaje): ?>
                <div class="alerta-exito" style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                    <?= htmlspecialchars($mensaje) ?>
                </div>
            <?php endif; ?>

            <!-- Formulario de creación de usuario -->
            <form method="POST" action="">

                <!-- ── Datos de acceso ─────────────────────────── -->
                <div class="grupo-formulario">
                    <label class="etiqueta-formulario" for="nombre_usuario">Nombre de Usuario</label>
                    <input type="text" id="nombre_usuario" name="nombre_usuario"
                           class="control-formulario" required>
                </div>

                <div class="grupo-formulario">
                    <label class="etiqueta-formulario" for="correo">Correo Electrónico</label>
                    <input type="email" id="correo" name="correo"
                           class="control-formulario" required>
                </div>

                <div class="grupo-formulario">
                    <label class="etiqueta-formulario" for="contrasena">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena"
                           class="control-formulario" required>
                </div>

                <div class="grupo-formulario">
                    <label class="etiqueta-formulario" for="rol">Rol</label>
                    <select id="rol" name="rol" class="control-formulario">
                        <option value="estudiante">Estudiante</option>
                        <option value="profesor">Profesor</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>

                <!-- ── Datos personales (opcionales) ──────────── -->
                <div style="border-top: 1px solid #e5e7eb; margin: 2rem 0; padding-top: 1rem;">
                    <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">Información Personal</h3>

                    <div class="grupo-formulario">
                        <label class="etiqueta-formulario" for="nombre_completo">Nombre Completo</label>
                        <input type="text" id="nombre_completo" name="nombre_completo"
                               class="control-formulario" placeholder="Ej. Juan Pérez">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="grupo-formulario">
                            <label class="etiqueta-formulario" for="telefono">Teléfono</label>
                            <input type="tel" id="telefono" name="telefono"
                                   class="control-formulario" placeholder="+34 600 000 000">
                        </div>
                        <div class="grupo-formulario">
                            <label class="etiqueta-formulario" for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                                   class="control-formulario">
                        </div>
                    </div>

                    <div class="grupo-formulario">
                        <label class="etiqueta-formulario" for="genero">Género</label>
                        <select id="genero" name="genero" class="control-formulario">
                            <option value="">Seleccionar...</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                            <option value="O">Otro</option>
                        </select>
                    </div>

                    <div class="grupo-formulario">
                        <label class="etiqueta-formulario" for="direccion">Dirección</label>
                        <textarea id="direccion" name="direccion"
                                  class="control-formulario" rows="2"></textarea>
                    </div>

                    <div class="grupo-formulario">
                        <label class="etiqueta-formulario" for="notas">Notas Administrativas</label>
                        <textarea id="notas" name="notas"
                                  class="control-formulario" rows="3"
                                  placeholder="Observaciones internas..."></textarea>
                    </div>
                </div>

                <div style="margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primario">Crear Usuario</button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>
