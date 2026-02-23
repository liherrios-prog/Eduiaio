<?php
/**
 * includes/funciones.php
 *
 * Funciones auxiliares de uso general en toda la aplicación.
 * Centraliza lógica que antes se repetía en varias páginas.
 */

/**
 * Calcula el porcentaje de progreso de un curso.
 * Devuelve 0 si no hay lecciones para evitar divisiones por cero.
 *
 * @param int $completadas Número de lecciones completadas.
 * @param int $total       Número total de lecciones.
 * @return int             Porcentaje entre 0 y 100.
 */
function calcular_porcentaje(int $completadas, int $total): int
{
    if ($total <= 0) {
        return 0;
    }
    return (int) round(($completadas / $total) * 100);
}

/**
 * Devuelve un emoji representativo para un curso según palabras clave en el título.
 * Usado en el panel del estudiante para mostrar un icono visual.
 *
 * @param string $titulo Título del curso.
 * @return string        Emoji representativo.
 */
function obtener_icono_curso(string $titulo): string
{
    $titulo = mb_strtolower($titulo);

    if (str_contains($titulo, 'whatsapp'))  return '💬';
    if (str_contains($titulo, 'banca'))     return '💳';
    if (str_contains($titulo, 'seguridad')) return '🛡️';
    if (str_contains($titulo, 'video'))     return '🎬';
    if (str_contains($titulo, 'correo'))    return '📧';
    if (str_contains($titulo, 'móvil') || str_contains($titulo, 'movil')) return '📱';

    return '🎓'; // icono predeterminado
}

/**
 * Devuelve la clase CSS correspondiente al rol de un usuario.
 * Usada en las tablas de administración para colorear el badge de rol.
 *
 * @param string $rol Rol del usuario ('admin', 'profesor', 'estudiante').
 * @return string     Clase CSS del badge.
 */
function clase_badge_rol(string $rol): string
{
    return match ($rol) {
        'admin'      => 'rol-admin',
        'profesor'   => 'rol-profesor',
        default      => 'rol-estudiante',
    };
}

/**
 * Suma la duración total (en minutos) de todas las lecciones de un array de módulos.
 *
 * @param array $modulos Array de módulos, cada uno con clave 'lecciones' que tiene 'duracion'.
 * @return int           Total de minutos.
 */
function calcular_duracion_total(array $modulos): int
{
    $total = 0;
    foreach ($modulos as $modulo) {
        foreach ($modulo['lecciones'] as $leccion) {
            $total += (int) ($leccion['duracion'] ?? 0);
        }
    }
    return $total;
}
