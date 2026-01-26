<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: iniciar_sesion.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel - EDUIAIO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="recursos/estilos/estilos.css">
</head>

<body>
    <header class="cabecera-navegacion">
        <div class="contenedor contenido-navegacion">
            <h2 class="titulo-panel">EDUIAIO <span>Admin Panel</span></h2>
            <div class="info-usuario">
                <span>Hola, <strong>
                        <?= htmlspecialchars($_SESSION['nombre_usuario']) ?>
                    </strong></span>
                <a href="cerrar_sesion.php" class="btn btn-peligro texto-pequeno">Cerrar Sesión</a>
            </div>
        </div>
    </header>

    <main class="contenedor">
        <!-- Estadísticas -->
        <div class="cuadricula-estadisticas">
            <div class="tarjeta-estadistica">
                <div class="etiqueta-estadistica">Estado de Conexión</div>
                <div class="valor-estadistica">Activa</div>
            </div>
            <div class="tarjeta-estadistica">
                <div class="etiqueta-estadistica">Rol de Usuario</div>
                <div class="valor-estadistica valor-estadistica-medio">
                    <?= ucfirst($_SESSION['rol']) ?>
                </div>
            </div>
            <div class="tarjeta-estadistica">
                <div class="etiqueta-estadistica">Fase Actual</div>
                <div class="valor-estadistica valor-estadistica-acento">Fase 2</div>
            </div>
        </div>

        <!-- Acciones Principales -->
        <div class="tarjeta-accion">
            <h2>Gestión de Cursos</h2>
            <p>Accede al panel de administración para crear, editar y
                eliminar cursos de la plataforma.</p>
            <a href="operaciones/listar.php" class="btn btn-claro">Ir al CRUD de Cursos</a>
        </div>

        <div class="tarjeta-accion" style="margin-top: 2rem;">
            <h2>Gestión de Usuarios</h2>
            <p>Administra los usuarios de la plataforma: Estudiantes, Profesores y Administradores.</p>
            <a href="operaciones/listar_usuarios.php" class="btn btn-claro">Ir al CRUD de Usuarios</a>
        </div>
    </main>
</body>

</html>