<?php
/**
 * operaciones/editar_usuario.php
 *
 * Formulario para editar los datos de un usuario existente.
 * La contraseña solo se actualiza si se introduce una nueva.
 */

session_start();
require_once '../configuracion/conexion.php';
require_once '../includes/auth.php';

// Solo administradores pueden editar usuarios
requerir_sesion('../iniciar_sesion.php');

// ── Validar ID pasado por URL ─────────────────────────────────────────
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: listar_usuarios.php');
    exit;
}

$error   = '';
$mensaje = '';

// Obtener datos actuales del usuario
$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = :id");
$stmt->execute(['id' => $id]);
$usuario = $stmt->fetch();

if (!$usuario) {
    header('Location: listar_usuarios.php');
    exit;
}

// ── Procesamiento del formulario ──────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario   = trim($_POST['nombre_usuario'] ?? '');
    $correo           = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $rol              = $_POST['rol'] ?? '';
    $nueva_contrasena = $_POST['contrasena'] ?? '';

    if ($nombre_usuario && $correo && $rol) {
        try {
            // Campos personales opcionales
            $campos_extra = [
                'nombre_completo'  => $_POST['nombre_completo'] ?? null,
                'telefono'         => $_POST['telefono']        ?? null,
                'direccion'        => $_POST['direccion']       ?? null,
                'fecha_nacimiento' => !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null,
                'genero'           => !empty($_POST['genero'])  ? $_POST['genero'] : null,
                'notas'            => $_POST['notas']           ?? null,
            ];

            if (!empty($nueva_contrasena)) {
                // Actualizar incluyendo la nueva contraseña
                $sql = "UPDATE usuarios SET usuario=:usuario, email=:email, rol=:rol, clave=:clave,
                        nombre_completo=:nombre_completo, telefono=:telefono, direccion=:direccion,
                        fecha_nacimiento=:fecha_nacimiento, genero=:genero, notas=:notas WHERE id=:id";
                $params = array_merge(
                    ['usuario' => $nombre_usuario, 'email' => $correo, 'rol' => $rol,
                     'clave'  => password_hash($nueva_contrasena, PASSWORD_DEFAULT), 'id' => $id],
                    $campos_extra
                );
            } else {
                // Actualizar sin tocar la contraseña
                $sql = "UPDATE usuarios SET usuario=:usuario, email=:email, rol=:rol,
                        nombre_completo=:nombre_completo, telefono=:telefono, direccion=:direccion,
                        fecha_nacimiento=:fecha_nacimiento, genero=:genero, notas=:notas WHERE id=:id";
                $params = array_merge(
                    ['usuario' => $nombre_usuario, 'email' => $correo, 'rol' => $rol, 'id' => $id],
                    $campos_extra
                );
            }

            $conexion->prepare($sql)->execute($params);
            $mensaje = 'Usuario actualizado correctamente.';

            // Actualizar variables locales para reflejar cambios
            $usuario = array_merge($usuario, ['usuario' => $nombre_usuario, 'email' => $correo, 'rol' => $rol], $campos_extra);

        } catch (PDOException $e) {
            $error = 'Error al actualizar el usuario. Inténtalo de nuevo.';
        }
    } else {
        $error = 'Usuario, correo y rol son obligatorios.';
    }
}

// ── Variables para el fragmento <head> ───────────────────────────────
$titulo_pagina = 'Editar Usuario';
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

                <div style="border-top: 1px solid #e5e7eb; margin: 2rem 0; padding-top: 1rem;">
                    <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">Información Personal</h3>
                    
                    <div class="grupo-formulario">
                        <label class="etiqueta-formulario" for="nombre_completo">Nombre Completo</label>
                        <input type="text" id="nombre_completo" name="nombre_completo" class="control-formulario" 
                            value="<?= htmlspecialchars($usuario['nombre_completo'] ?? '') ?>" placeholder="Ej. Juan Pérez">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="grupo-formulario">
                            <label class="etiqueta-formulario" for="telefono">Teléfono</label>
                            <input type="tel" id="telefono" name="telefono" class="control-formulario" 
                                value="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>" placeholder="+34 600 000 000">
                        </div>
                        <div class="grupo-formulario">
                            <label class="etiqueta-formulario" for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="control-formulario"
                                value="<?= htmlspecialchars($usuario['fecha_nacimiento'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="grupo-formulario">
                        <label class="etiqueta-formulario" for="genero">Género</label>
                        <select id="genero" name="genero" class="control-formulario">
                            <option value="">Seleccionar...</option>
                            <option value="M" <?= ($usuario['genero'] ?? '') == 'M' ? 'selected' : '' ?>>Masculino</option>
                            <option value="F" <?= ($usuario['genero'] ?? '') == 'F' ? 'selected' : '' ?>>Femenino</option>
                            <option value="O" <?= ($usuario['genero'] ?? '') == 'O' ? 'selected' : '' ?>>Otro</option>
                        </select>
                    </div>

                    <div class="grupo-formulario">
                        <label class="etiqueta-formulario" for="direccion">Dirección</label>
                        <textarea id="direccion" name="direccion" class="control-formulario" rows="2"><?= htmlspecialchars($usuario['direccion'] ?? '') ?></textarea>
                    </div>

                    <div class="grupo-formulario">
                        <label class="etiqueta-formulario" for="notas">Notas Administrativas</label>
                        <textarea id="notas" name="notas" class="control-formulario" rows="3" placeholder="Observaciones internas..."><?= htmlspecialchars($usuario['notas'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="acciones-formulario" style="margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primario">Actualizar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
