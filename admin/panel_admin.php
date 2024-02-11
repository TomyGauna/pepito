<?php
// Incluir el archivo de conexión a la base de datos
require('../includes/conexion.php');

// Iniciar sesión
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    // Redirigir al usuario al formulario de inicio de sesión si no está autenticado
    header('Location: ../login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <div class="admin-container">
        <h2>Bienvenido al Panel de Administración</h2>
        <p>¡Hola, <?php echo $_SESSION['usuario']; ?>!</p>
        <ul>
            <li><a href="agregar_noticia.php">Agregar Noticia</a></li>
            <li><a href="lista_noticias.php">Lista de Noticia</a></li>
            <li><a href="gestion_usuarios.php">Gestionar Usuarios</a></li>
            <li><a href="../logout.php">Cerrar Sesión</a></li>
            <li><a href="../index.php">ir al index</a></li>
        </ul>
    </div>
</body>
</html>