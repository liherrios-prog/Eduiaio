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
    <style>
        .cabecera-navegacion {
            background: white;
            box-shadow: var(--sombra-sm);
            padding: 1rem 0;
            margin-bottom: 2rem;
        }

        .contenido-navegacion {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cuadricula-estadisticas {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .tarjeta-estadistica {
            background: white;
            padding: 1.5rem;
            border-radius: var(--radio-lg);
            box-shadow: var(--sombra-sm);
        }

        .valor-estadistica {
            font-size: 2rem;
            font-weight: 700;
            color: var(--color-primario);
        }

        .etiqueta-estadistica {
            color: var(--texto-secundario);
            font-size: 0.875rem;
        }

        .tarjeta-accion {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            color: white;
            padding: 2rem;
            border-radius: var(--radio-lg);
            text-align: center;
        }

        .tarjeta-accion h2 {
            margin-top: 0;
        }

        .btn-claro {
            background: white;
            color: var(--color-primario);
        }

        .btn-claro:hover {
            background: #F3F4F6;
        }
    </style>
</head>

<body>
    <header class="cabecera-navegacion">
        <div class="contenedor contenido-navegacion">
            <h2 style="margin:0; color: var(--color-primario);">EDUIAIO <span
                    style="font-weight:400; color: var(--texto-principal);">Panel</span></h2>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span>Hola, <strong>
                        <?= htmlspecialchars($_SESSION['nombre_usuario']) ?>
                    </strong></span>
                <a href="cerrar_sesion.php" class="btn btn-peligro" style="font-size: 0.875rem;">Cerrar Sesión</a>
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
                <div class="valor-estadistica" style="font-size: 1.5rem;">
                    <?= ucfirst($_SESSION['rol']) ?>
                </div>
            </div>
            <div class="tarjeta-estadistica">
                <div class="etiqueta-estadistica">Fase Actual</div>
                <div class="valor-estadistica" style="color: var(--color-acento);">Fase 2</div>
            </div>
        </div>

        <!-- Acciones Principales -->
        <div class="tarjeta-accion">
            <h2>Gestión de Cursos</h2>
            <p style="margin-bottom: 1.5rem; opacity: 0.9;">Accede al panel de administración para crear, editar y
                eliminar cursos de la plataforma.</p>
            <a href="operaciones/listar.php" class="btn btn-claro">Ir al CRUD de Cursos</a>
        </div>
    </main>
</body>

</html>