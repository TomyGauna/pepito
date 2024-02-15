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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <div class="admin-container">
        <h2>Bienvenido al Panel de Administración</h2>
        <p>¡Hola, <?php echo $_SESSION['usuario']; ?>!</p>
        <ul>
            <h2>Notas</h2>
            <li><a href="agregar_noticia.php">Agregar Noticia</a></li>
            <li><a href="lista_noticias.php">Lista de Noticia</a></li>
            <hr></hr>
            <h2>Publis</h2>
            <li><a href="agregar_publi.php">Agregar Publi</a></li>
            <li><a href="lista_publi.php">Lista de Publi</a></li>
            <hr></hr>
            <h2>Usuarios</h2>
            <li><a href="gestion_usuarios.php">Gestionar Usuarios</a></li>
            <li><a href="../logout.php">Cerrar Sesión</a></li>
            <hr></hr>
            <h2>Index</h2>
            <li><a href="../index.php">ir al index</a></li>
        </ul>
    </div>
</body>
</html>