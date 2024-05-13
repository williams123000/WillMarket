<?php
    // php para establecer la conexión a la base de datos MySQL 
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'willmarket';

    $conexion = new mysqli($host, $user, $password, $database);
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

?>