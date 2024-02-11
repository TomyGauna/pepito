<?php
// Datos de conexión a la base de datos
$host = 'localhost'; // Cambiar si es necesario
$usuario = 'root';
$contraseña = '';
$base_datos = 'el_trebol';

// Crear conexión
$conexion = new mysqli($host, $usuario, $contraseña, $base_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
} else {
    echo "Conexión exitosa a la base de datos";
}

// Establecer juego de caracteres a UTF-8
$conexion->set_charset("utf8");
?>