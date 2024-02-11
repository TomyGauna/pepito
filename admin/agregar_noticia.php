<?php
// Incluir el archivo de conexión a la base de datos
require('../includes/conexion.php');

// Verificar si se envió el formulario con un archivo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['imagen'])) {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $contenido_2 = $_POST['contenido_2'];
    $contenido_3 = $_POST['contenido_3'];
    $contenido_4 = $_POST['contenido_4'];
    $is_field = $_POST['is_field'];
    
    // Guardar solo el nombre del archivo de la imagen
    $imagen = $_FILES['imagen']['name'];
    $imagen_2 = $_FILES['imagen_2']['name'];
    $imagen_3 = $_FILES['imagen_3']['name'];

    $imagen_temporal = $_FILES['imagen']['tmp_name']; // Ruta temporal del archivo subido
    $imagen_ruta = "../img/" . $imagen; // Ruta final donde se guardará la imagen

    $imagen_temporal_2 = $_FILES['imagen_2']['tmp_name']; // Ruta temporal del archivo subido
    $imagen_ruta_2 = "../img/" . $imagen_2; // Ruta final donde se guardará la imagen

    $imagen_temporal_3 = $_FILES['imagen_3']['tmp_name']; // Ruta temporal del archivo subido
    $imagen_ruta_3 = "../img/" . $imagen_3; // Ruta final donde se guardará la imagen

    $segment = $_POST['segment'];
    $region = $_POST['region'];
    $priority_segment = $_POST['priority_segment'];
    $priority_region = $_POST['priority_region'];

    // Mover la imagen a la ubicación deseada en el servidor
    move_uploaded_file($imagen_temporal, $imagen_ruta);
    move_uploaded_file($imagen_temporal_2, $imagen_ruta_2);
    move_uploaded_file($imagen_temporal_3, $imagen_ruta_3);

    // Preparar la consulta para agregar la noticia
    $consulta = "INSERT INTO noticias (titulo, contenido, contenido_2, contenido_3, contenido_4, is_field, imagen, imagen_2, imagen_3, segment, region, priority_segment, priority_region, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

    // Preparar la declaración
    $stmt = $conexion->prepare($consulta);

    // Enlazar parámetros
    $stmt->bind_param("sssssssssssss", $titulo, $contenido, $contenido_2, $contenido_3, $contenido_4, $is_field, $imagen, $imagen_2, $imagen_3, $segment, $region, $priority_segment, $priority_region);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Noticia agregada correctamente.";
        header("Location: panel_admin.php");
        exit();
    } else {
        echo "Error al agregar la noticia: " . $conexion->error;
    }

    // Cerrar la consulta
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Noticia</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <div class="container">
        <h2>Agregar Noticia</h2>
        <form method="POST" action="agregar_noticia.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo">Titulo:</label>
                <input type="text" class="form-control" name="titulo" required>
            </div>

            <div class="form-group">
                <label for="contenido">Content:</label>
                <textarea class="form-control" name="contenido"></textarea>
            </div>

            <div class="form-group">
                <label for="contenido_2">Content 2:</label>
                <textarea class="form-control" name="contenido_2"></textarea>
            </div>

            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" class="form-control-file" name="imagen" accept="image/*">
            </div>

            <div class="form-group">
                <label for="contenido_3">Content 3:</label>
                <textarea class="form-control" name="contenido_3"></textarea>
            </div>

            <div class="form-group">
                <label for="imagen_2">Image 2:</label>
                <input type="file" class="form-control-file" name="imagen_2" accept="image/*">
            </div>

            <div class="form-group">
                <label for="contenido_4">Content 4:</label>
                <textarea class="form-control" name="contenido_4"></textarea>
            </div>

            <div class="form-group">
                <label for="imagen_3">Image 3:</label>
                <input type="file" class="form-control-file" name="imagen_3" accept="image/*">
            </div>

            <div class="form-group">
                <label for="is_field">Is Field:</label>
                <select class="form-control" name="is_field">
                    <option value="none">None</option>
                    <option value="1">Field 1</option>
                    <option value="2">Field 2</option>
                    <option value="3">Field 3</option>
                    <option value="4">Field 4</option>
                    <option value="5">Field 5</option>
                    <option value="6">Field 6</option>
                    <option value="7">Field 7</option>
                    <option value="8">Field 8</option>
                    <option value="9">Field 9</option>
                    <option value="10">Field 10</option>
                    <option value="11">Field 11</option>
                    <option value="12">Field 12</option>
                    <option value="13">Field 13</option>
                    <option value="14">Field 14</option>
                    <option value="15">Field 15</option>
                    <!-- Agrega más opciones según sea necesario -->
                </select>
            </div>

            <label for="region">Region:</label>
            <select class="form-control" name="region">
                <option value="san_martin">San Martin</option>
                <option value="tres_de_febrero">Tres de Febrero</option>
                <option value="malvinas_argentinas">Malvinas Argentinas</option>
                <option value="san_isidro">San Isidro</option>
                <option value="vicente_lopez">Vicente Lopez</option>
                <option value="none">None</option>
            </select>

            <div class="form-group">
                <label for="priority_region">Priority Region:</label>
                <select class="form-control" name="priority_region">
                    <option value="primary">Primary</option>
                    <option value="secondary">Secondary</option>
                    <option value="none">None</option>
                </select>
            </div>

            <label for="segment">Segment:</label>
            <select class="form-control" name="segment">
                <option value="politica">Politica</option>
                <option value="sociedad">Sociedad</option>
                <option value="cultura">Cultura</option>
                <option value="deportes">Deportes</option>
                <option value="unsam">UNSAM</option>
                <option value="none">None</option>
            </select>

            <div class="form-group">
                <label for="priority_segment">Priority Segment:</label>
                <select class="form-control" name="priority_segment">
                    <option value="primary">Primary</option>
                    <option value="secondary">Secondary</option>
                    <option value="none">None</option>
                </select>
            </div>

            <div class="form-group">
                <label for="dia_creacion">Fecha:</label>
                <input type="text" class="form-control" name="dia_creacion"></input> 
            </div>

            <button type="reset" class="btn btn-primary">Reset Note</button>
            <button type="submit" class="btn btn-primary">Save Note</button>
        </form>
        
        <a href="panel_admin.php"><button>Volver al inicio</button></a>
    </div>
</body>
</html>