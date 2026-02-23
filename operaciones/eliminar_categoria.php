<?php
/**
 * operaciones/eliminar_categoria.php
 *
 * Elimina una categoría existente.
 */

session_start();
require_once '../configuracion/conexion.php';
require_once '../includes/auth.php';

// Verificar sesión activa
requerir_sesion('../iniciar_sesion.php');

// ── Validar ID de la categoría pasado por URL ──────────────────────────
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: listar_categorias.php');
    exit;
}

// Obtener los datos de la categoría
$consulta = $conexion->prepare("SELECT * FROM categorias WHERE id = ?");
$consulta->execute([$id]);
$categoria = $consulta->fetch();

if (!$categoria) {
    header('Location: listar_categorias.php');
    exit;
}

try {
    // Verificar si hay cursos asociados a esta categoría
    $check = $conexion->prepare("SELECT COUNT(*) as cantidad FROM cursos WHERE categoria_id = ?");
    $check->execute([$id]);
    $result = $check->fetch();
    
    if ($result['cantidad'] > 0) {
        // No permitir eliminar si hay cursos asociados
        $_SESSION['alerta'] = [
            'tipo' => 'error',
            'mensaje' => "No puede eliminar la categoría porque tiene {$result['cantidad']} curso(s) asociado(s)."
        ];
    } else {
        // Eliminar la categoría
        $stmt = $conexion->prepare("DELETE FROM categorias WHERE id = ?");
        $stmt->execute([$id]);
        
        $_SESSION['alerta'] = [
            'tipo' => 'exito',
            'mensaje' => 'Categoría eliminada exitosamente.'
        ];
    }
} catch (PDOException $e) {
    $_SESSION['alerta'] = [
        'tipo' => 'error',
        'mensaje' => 'Error al eliminar la categoría: ' . $e->getMessage()
    ];
}

header('Location: listar_categorias.php');
exit;
?>
