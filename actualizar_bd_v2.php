<?php
require_once 'configuracion/conexion.php';

echo "Start Update Process...<br>";

try {
    $host = 'localhost';
    $user = 'root';
    $pass = ''; 
    
    // Command line approach
    $mysqlPath = 'C:\\xampp\\mysql\\bin\\mysql.exe';
    if (!file_exists($mysqlPath)) {
        $mysqlPath = 'mysql';
    }
    
    $cmd = "\"$mysqlPath\" -u $user -h $host < base_de_datos/eduiaio_es.sql";
    echo "Executing: $cmd <br>";
    
    $out = [];
    $res = 0;
    exec($cmd . " 2>&1", $out, $res);
    
    if ($res === 0) {
        echo "<h1>Base de datos actualizada correctamente</h1>";
    } else {
        echo "<h1>Error ($res)</h1>";
        echo "<pre>" . print_r($out, true) . "</pre>";
    }

} catch (Exception $e) {
    echo "Ex: " . $e->getMessage();
}
?>
