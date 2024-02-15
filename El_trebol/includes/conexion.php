<?php
// Datos de conexión a la base de datos
$host = 'localhost'; // Cambiar si es necesario
$usuario = 'root';
$contraseña = '';
$base_datos = 'el_trebol';

// Crear conexión
$conexion = new mysqli($host, $usuario, $contraseña, $base_datos);

// Establecer juego de caracteres a UTF-8
$conexion->set_charset("utf8");
?>