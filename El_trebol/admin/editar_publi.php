<?php
// Incluir el archivo de conexión a la base de datos
require('../includes/conexion.php');

// Definir variables para evitar advertencias de "Undefined variable"
$id_noticia = $titulo = $contenido = $categoria = "";
$mensaje = "";


// Verificar si se recibió un ID de noticia para editar
if (isset($_GET['id_noticia'])) {
    // Obtener el ID de noticia desde la URL
    $id_noticia = $_GET['id_noticia'];

    // Consultar la información de la noticia
    $consulta_noticia_individual = "SELECT * FROM noticias WHERE id = $id_noticia";
    $resultado_noticia = $conexion->query($consulta_noticia_individual);

    // Verificar si se encontró la noticia
    if ($resultado_noticia->num_rows > 0) {
        $fila_noticia = $resultado_noticia->fetch_assoc();

        // Asignar valores a las variables
        $titulo = $fila_noticia['titulo'];
        $contenido = $fila_noticia['contenido'];
        $categoria = $fila_noticia['categoria'];
    } else {
        echo "No se encontró la noticia.";
    }
}

// Verificar si se envió el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $id_noticia = $_POST['id_noticia'];
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $categoria = $_POST['categoria'];

    // Preparar la consulta para actualizar la noticia
    $consulta_actualizar = "UPDATE noticias SET titulo=?, contenido=?, categoria=? WHERE id=?";

    // Preparar la declaración
    $stmt = $conexion->prepare($consulta_actualizar);

    // Enlazar parámetros
    $stmt->bind_param("sssi", $titulo, $contenido, $categoria, $id_noticia);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $mensaje = "La noticia se actualizó correctamente.";
    } else {
        $mensaje = "Error al actualizar la noticia: " . $conexion->error;
    }

    if ($stmt->execute()) {
        // Redirigir al panel de administración
        header("Location: panel_admin.php");
        exit(); // Asegura que el script se detenga después de la redirección
    } else {
        echo "Error al agregar la noticia: " . $conexion->error;
    }

    // Cerrar la consulta
    $stmt->close();
}

// Cerrar la conexión
$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Noticia</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="admin-container">
        <h2>Editar Noticia</h2>
        <!-- Mostrar mensaje -->
        <?php if (!empty($mensaje)): ?>
            <p><?php echo $mensaje; ?></p>
        <?php endif; ?>

        <!-- Formulario para editar noticias -->
        <form method="POST" action="editar_noticia.php">
            <input type="hidden" name="id_noticia" value="<?php echo $id_noticia; ?>">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo $titulo; ?>">
            <label for="contenido">Contenido:</label>
            <textarea id="contenido" name="contenido"><?php echo $contenido; ?></textarea>
            <label for="categoria">Categoría:</label>
            <input type="text" id="categoria" name="categoria" value="<?php echo $categoria; ?>">
            <input type="submit" value="Guardar Cambios">
        </form>
    </div>
</body>
</html>
