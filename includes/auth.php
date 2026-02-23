<?php
/**
 * includes/auth.php
 *
 * Funciones de autenticación y control de acceso.
 * Se incluye en cualquier página que requiera sesión iniciada.
 */

/**
 * Asegura que existe una sesión activa.
 * Si no hay usuario logueado, redirige al login y detiene la ejecución.
 *
 * @param string $ruta_login Ruta relativa al archivo de login (varía según profundidad del archivo que llama).
 */
function requerir_sesion(string $ruta_login = '../iniciar_sesion.php'): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['id_usuario'])) {
        header('Location: ' . $ruta_login);
        exit;
    }
}

/**
 * Asegura que el usuario tiene un rol concreto.
 * Si el rol no coincide, redirige al panel general.
 *
 * @param string $rol_requerido Rol que debe tener el usuario ('admin', 'profesor', 'estudiante').
 * @param string $ruta_panel   Ruta al panel al que redirigir si no tiene permiso.
 */
function requerir_rol(string $rol_requerido, string $ruta_panel = '../panel.php'): void
{
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== $rol_requerido) {
        header('Location: ' . $ruta_panel);
        exit;
    }
}

/**
 * Devuelve verdadero si el usuario tiene el rol indicado.
 *
 * @param string $rol Rol a comprobar.
 */
function tiene_rol(string $rol): bool
{
    return isset($_SESSION['rol']) && $_SESSION['rol'] === $rol;
}
