<?php
require_once 'configuracion/conexion.php';

try {
    // Leer el archivo SQL
    $sql = file_get_contents('base_de_datos/eduiaio_es.sql');
    
    // Ejecutar multiquery
    // Nota: PDO no soporta múltiples queries en una sola llamada prepare/execute de forma nativa fácil para scripts complejos con DELIMITER,
    // pero para este dump sencillo (sin delimiters complejos intermedios mas que el trigger) podemos intentarlo o dividirlo.
    // El archivo tiene DELIMITER, lo cual PDO no procesa directamente.
    // Vamos a procesarlo manualmente simple.
    
    // 1. Conexión sin DB seleccionada para poder hacer DROP/CREATE
    $host = 'localhost';
    $user = 'root';
    $pass = ''; // Asumimos default XAMPP
    
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 2. Limpiar el SQL de comandos DELIMITER que no son SQL estándar
    // En este caso, como es un script de setup completo, lo mejor es ejecutar bloque a bloque.
    
    // Eliminamos comentarios
    $sql = preg_replace('/--.*$/m', '', $sql);
    
    // Separamos por ; pero tenemos cuidado con el trigger.
    // Una estrategia simple para este caso específico:
    // Ejecutar todo lo que no es el trigger, y luego el trigger.
    
    // Actually, shelling out to mysql client is safer/easier if available in XAMPP
    $output = [];
    $retVal = 0;
    // Intentar ejecutar via comando de sistema asumiendo XAMPP en path o ruta estándar
    $mysqlPath = 'C:\\xampp\\mysql\\bin\\mysql.exe';
    if (!file_exists($mysqlPath)) {
        $mysqlPath = 'mysql'; // Try system path
    }
    
    $command = "\"$mysqlPath\" -u $user -h $host < base_de_datos/eduiaio_es.sql";
    if (file_exists('base_de_datos/eduiaio_es.sql')) {
        exec($command . " 2>&1", $output, $retVal);
        
        if ($retVal === 0) {
            echo "<h1>Base de datos actualizada correctamente</h1>";
            echo "<p>Se han aplicado las nuevas categorías y cursos para el público objetivo.</p>";
            echo "<a href='index.php'>Volver al Inicio</a>";
        } else {
            echo "<h1>Error al actualizar</h1>";
            echo "<pre>" . print_r($output, true) . "</pre>";
            // Fallback: Ejecución PHP manual (parcial/best effort)
            echo "<p>Intentando ejecución manual PHP...</p>";
            manualImport($pdo, $sql);
        }
    } else {
        echo "No se encuentra el archivo SQL";
    }

} catch (Exception $e) {
    echo "Excepción: " . $e->getMessage();
}

function manualImport($pdo, $sql) {
    // Implementación simple para fallback
    // Remover DELIMITER lines
    $sql = preg_replace('/DELIMITER \/\/|DELIMITER ;|\/\//', '', $sql);
    $stmts = explode(';', $sql);
    
    foreach ($stmts as $stmt) {
        $stmt = trim($stmt);
        if (!empty($stmt)) {
            try {
                $pdo->exec($stmt);
            } catch (Exception $e) {
                echo "Error en query: " . substr($stmt, 0, 100) . "... <br>VB: " . $e->getMessage() . "<br>";
            }
        }
    }
    echo "<h3>Importación manual finalizada (revisar errores arriba si los hay)</h3>";
}
?>
