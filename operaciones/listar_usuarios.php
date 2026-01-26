<?php
session_start();
require_once '../configuracion/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../iniciar_sesion.php');
    exit;
}

// Obtener Usuarios
$consulta = $conexion->query("SELECT * FROM usuarios ORDER BY fecha_creacion DESC");
$usuarios = $consulta->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - EDUIAIO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../recursos/estilos/estilos.css">
    <style>
        .badge-rol {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .rol-admin { background-color: #fee2e2; color: #991b1b; }
        .rol-profesor { background-color: #fef3c7; color: #92400e; }
        .rol-estudiante { background-color: #d1fae5; color: #065f46; }
    </style>
</head>

<body>
    <div class="contenedor">
        <!-- Cabecera -->
        <div class="cabecera-lista">
            <div>
                <h1 class="titulo-lista">Lista de Usuarios</h1>
                <p class="subtitulo-lista">Administra los usuarios del sistema</p>
            </div>
            <div class="acciones-cabecera">
                <a href="../panel.php" class="btn btn-volver">Volver al Panel</a>
                <a href="crear_usuario.php" class="btn btn-primario">+ Nuevo Usuario</a>
            </div>
        </div>

        <!-- Tarjeta con Tabla -->
        <div class="tarjeta contenedor-tabla">
            <table class="tabla-base">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Fecha Creación</th>
                        <th class="td-derecha">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr class="fila-tabla">
                            <td style="font-weight: 500;">#<?= $usuario['id'] ?></td>
                            <td><?= htmlspecialchars($usuario['usuario']) ?></td>
                            <td><?= htmlspecialchars($usuario['email']) ?></td>
                            <td>
                                <?php
                                $clase_rol = 'rol-estudiante';
                                if ($usuario['rol'] === 'admin') $clase_rol = 'rol-admin';
                                if ($usuario['rol'] === 'profesor') $clase_rol = 'rol-profesor';
                                ?>
                                <span class="badge-rol <?= $clase_rol ?>">
                                    <?= ucfirst($usuario['rol']) ?>
                                </span>
                            </td>
                            <td class="texto-secundario">
                                <?= date('d/m/Y', strtotime($usuario['fecha_creacion'])) ?>
                            </td>
                            <td class="td-derecha">
                                <a href="editar_usuario.php?id=<?= $usuario['id'] ?>" class="btn btn-texto-primario">Editar</a>
                                <?php if ($usuario['id'] != $_SESSION['id_usuario']): // Evitar auto-eliminación ?>
                                    <a href="eliminar_usuario.php?id=<?= $usuario['id'] ?>" class="btn btn-texto-peligro"
                                        onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if (empty($usuarios)): ?>
                <div class="mensaje-vacio">
                    No hay usuarios registrados.
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
