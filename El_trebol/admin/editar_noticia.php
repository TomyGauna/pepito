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
        $contenido_2 = $fila_noticia['contenido_2'];
        $contenido_3 = $fila_noticia['contenido_3'];
        $contenido_4 = $fila_noticia['contenido_4'];
        $is_field = $fila_noticia['is_field'];
        $imagen = $fila_noticia['imagen'];
        $imagen_2 = $fila_noticia['imagen_2'];
        $imagen_3 = $fila_noticia['imagen_3'];

        $video = $fila_noticia['video'];
        $video_2 = $fila_noticia['video_2'];
        $video_3 = $fila_noticia['video_3'];
        $segment = $fila_noticia['segment'];
        $region = $fila_noticia['region'];
        $priority_segment = $fila_noticia['priority_segment'];
        $priority_region = $fila_noticia['priority_region'];
    } else {
        echo "No se encontró la noticia.";
    }
}

// Verificar si se envió el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['imagen'])) {
    // Obtener datos del formulario
    $id_noticia = $_POST['id_noticia'];
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $contenido_2 = $_POST['contenido_2'];
    $contenido_3 = $_POST['contenido_3'];
    $contenido_4 = $_POST['contenido_4'];
    $is_field = $_POST['is_field'];

    $video = $_POST['video'];
    $video_2 = $_POST['video_2'];
    $video_3 = $_POST['video_3'];
    $segment = $_POST['segment'];
    $region = $_POST['region'];
    $priority_segment = $_POST['priority_segment'];
    $priority_region = $_POST['priority_region'];

    if (!empty($_FILES['imagen']['name'])) {
        $imagen = $_FILES['imagen']['name'];
        $imagen_temporal = $_FILES['imagen']['tmp_name'];
        $imagen_ruta = "../img/" . $imagen;
        move_uploaded_file($imagen_temporal, $imagen_ruta);
    }

    if (!empty($_FILES['imagen_2']['name'])) {
        $imagen_2 = $_FILES['imagen_2']['name'];
        $imagen_2_temporal = $_FILES['imagen_2']['tmp_name'];
        $imagen_2_ruta = "../img/" . $imagen_2;
        move_uploaded_file($imagen_2_temporal, $imagen_2_ruta);
    }

    if (!empty($_FILES['imagen_3']['name'])) {
        $imagen_3 = $_FILES['imagen_3']['name'];
        $imagen_3_temporal = $_FILES['imagen_3']['tmp_name'];
        $imagen_3_ruta = "../img/" . $imagen_3;
        move_uploaded_file($imagen_3_temporal, $imagen_3_ruta);
    }

    // Preparar la consulta para actualizar la noticia
    $consulta_actualizar = "UPDATE noticias SET titulo=?, contenido=?, contenido_2=?, contenido_3=?, contenido_4=?, is_field=?, video=?, video_2=?, video_3=?, segment=?, region=?, priority_segment=?, priority_region=? WHERE id=?";

    // Preparar la declaración
    $stmt = $conexion->prepare($consulta_actualizar);

    // Enlazar parámetros
    $stmt->bind_param("ssssssssssssss", $titulo, $contenido, $contenido_2, $contenido_3, $contenido_4, $is_field, $video, $video_2, $video_3, $segment, $region, $priority_segment, $priority_region, $id_noticia);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $mensaje = "La noticia se actualizó correctamente.";
        // Redirigir al panel de administración
        header("Location: panel_admin.php");
        exit(); // Asegura que el script se detenga después de la redirección
    } else {
        $mensaje = "Error al actualizar la noticia: " . $conexion->error;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <div class="admin-container">
        <h2>Editar Noticia</h2>
        <!-- Mostrar mensaje -->
        <?php if (!empty($mensaje)): ?>
            <p><?php echo $mensaje; ?></p>
        <?php endif; ?>

        <!-- Formulario para editar noticias -->
        <form method="POST" action="editar_noticia.php" enctype="multipart/form-data">
            <input type="hidden" name="id_noticia" value="<?php echo $id_noticia; ?>">
            
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo $titulo; ?>">
            </div>

            <div class="form-group">
                <label for="contenido">Contenido:</label>
                <textarea id="contenido" name="contenido"><?php echo $contenido; ?></textarea>
            </div>

            <div class="form-group">
                <label for="contenido_2">Content 2:</label>
                <textarea class="form-control" name="contenido_2"><?php echo $contenido_2; ?></textarea>
            </div>

            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" class="form-control-file" name="imagen" accept="image/*">
                <img src="../img/<?php echo $imagen; ?>" alt="">
            </div>

            <div class="form-group">
                <label for="video">Video:</label>
                <input class="form-control-file" name="video">
                <iframe src="<?php echo $noticia['video']; ?>" title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
            </div>

            <div class="form-group">
                <label for="contenido_3">Content 3:</label>
                <textarea class="form-control" name="contenido_3"><?php echo $contenido_3; ?></textarea>
            </div>

            <div class="form-group">
                <label for="imagen_2">Imagen 2:</label>
                <input type="file" class="form-control-file" name="imagen_2" accept="image/*">
                <img src="../img/<?php echo $imagen_2; ?>" alt="">
            </div>

            <div class="form-group">
                <label for="video_2">Video 2:</label>
                <input class="form-control-file" name="video_2">
                <iframe src="<?php echo $noticia['video_2']; ?>" title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
            </div>

            <div class="form-group">
                <label for="contenido_4">Content 4:</label>
                <textarea class="form-control" name="contenido_4"><?php echo $contenido_4; ?></textarea>
            </div>

            <div class="form-group">
                <label for="imagen_3">Image 3:</label>
                <input type="file" class="form-control-file" name="imagen_3" accept="image/*">
                <img src="../img/<?php echo $imagen_3; ?>" alt="">
            </div>

            <div class="form-group">
                <label for="video_3">Video 3:</label>
                <input class="form-control-file" name="video_3">
                <iframe src="<?php echo $noticia['video_3']; ?>" title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
            </div>

            <div class="form-group">
                <label for="is_field">Is Field:</label>
                <select class="form-control" name="is_field">
                    <option value="none">None</option>
                    <option value="1" <?php if ($is_field == '1') echo 'selected'; ?>>Field 1</option>
                    <option value="2" <?php if ($is_field == '2') echo 'selected'; ?>>Field 2</option>
                    <option value="3" <?php if ($is_field == '3') echo 'selected'; ?>>Field 3</option>
                    <option value="4" <?php if ($is_field == '4') echo 'selected'; ?>>Field 4</option>
                    <option value="5" <?php if ($is_field == '5') echo 'selected'; ?>>Field 5</option>
                    <option value="6" <?php if ($is_field == '6') echo 'selected'; ?>>Field 6</option>
                    <option value="7" <?php if ($is_field == '7') echo 'selected'; ?>>Field 7</option>
                    <option value="8" <?php if ($is_field == '8') echo 'selected'; ?>>Field 8</option>
                    <option value="9" <?php if ($is_field == '9') echo 'selected'; ?>>Field 9</option>
                    <option value="10" <?php if ($is_field == '10') echo 'selected'; ?>>Field 10</option>
                    <option value="11" <?php if ($is_field == '11') echo 'selected'; ?>>Field 11</option>
                    <option value="12" <?php if ($is_field == '12') echo 'selected'; ?>>Field 12</option>
                    <option value="13" <?php if ($is_field == '13') echo 'selected'; ?>>Field 13</option>
                    <option value="14" <?php if ($is_field == '14') echo 'selected'; ?>>Field 14</option>
                    <option value="15" <?php if ($is_field == '15') echo 'selected'; ?>>Field 15</option>
                    <!-- Agrega más opciones según sea necesario -->
                </select>
            </div>

            <label for="region">Region:</label>
            <select class="form-control" name="region">
                <option value="san_martin" <?php if ($region == 'san_martin') echo 'selected'; ?>>San Martin</option>
                <option value="tres_de_febrero" <?php if ($region == 'tres_de_febrero') echo 'selected'; ?>>Tres de Febrero</option>
                <option value="malvinas_argentinas" <?php if ($region == 'malvinas_argentinas') echo 'selected'; ?>>Malvinas Argentinas</option>
                <option value="san_isidro" <?php if ($region == 'san_isidro') echo 'selected'; ?>>San Isidro</option>
                <option value="vicente_lopez" <?php if ($region == 'vicente_lopez') echo 'selected'; ?>>Vicente Lopez</option>
                <option value="none" <?php if ($region == 'none') echo 'selected'; ?>>None</option>
            </select>

            <div class="form-group">
                <label for="priority_region">Priority Region:</label>
                <select class="form-control" name="priority_region">
                    <option value="primary" <?php if ($priority_region == 'primary') echo 'selected'; ?>>Primary</option>
                    <option value="secondary" <?php if ($priority_region == 'secondary') echo 'selected'; ?>>Secondary</option>
                    <option value="none" <?php if ($priority_region == 'none') echo 'selected'; ?>>None</option>
                </select>
            </div>

            <label for="segment">Segment:</label>
            <select class="form-control" name="segment">
                <option value="politica" <?php if ($segment == 'politica') echo 'selected'; ?>>Politica</option>
                <option value="sociedad" <?php if ($segment == 'sociedad') echo 'selected'; ?>>Sociedad</option>
                <option value="cultura" <?php if ($segment == 'cultura') echo 'selected'; ?>>Cultura</option>
                <option value="deportes" <?php if ($segment == 'deportes') echo 'selected'; ?>>Deportes</option>
                <option value="unsam" <?php if ($segment == 'unsam') echo 'selected'; ?>>UNSAM</option>
                <option value="none" <?php if ($segment == 'none') echo 'selected'; ?>>None</option>
            </select>

            <div class="form-group">
                <label for="priority_segment">Priority Segment:</label>
                <select class="form-control" name="priority_segment">
                    <option value="primary" <?php if ($priority_segment == 'primary') echo 'selected'; ?>>Primary</option>
                    <option value="secondary" <?php if ($priority_segment == 'secondary') echo 'selected'; ?>>Secondary</option>
                    <option value="none" <?php if ($priority_segment == 'none') echo 'selected'; ?>>None</option>
                </select>
            </div>

            <div class="form-group">
                <label for="dia_creacion">Fecha:</label>
                <input type="text" class="form-control" name="dia_creacion"></input> 
            </div>
            <input type="submit" value="Guardar Cambios">
        </form>
    </div>
</body>
</html>
