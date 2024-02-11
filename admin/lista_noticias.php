<?php
// Incluir el archivo de conexión a la base de datos
require('../includes/conexion.php');

// Obtener todas las noticias
$consulta_noticias = "SELECT * FROM noticias";
$resultado = $conexion->query($consulta_noticias);

if ($resultado->num_rows > 0) {
    // Mostrar todas las noticias en forma de lista
    while ($fila = $resultado->fetch_assoc()) {
        echo "<div>";
        echo "<h3>" . $fila['titulo'] . "</h3>";
        echo "<p>" . $fila['contenido'] . "</p>";
        echo "<p><strong>Categoría:</strong> " . $fila['categoria'] . "</p>";
        // Botón para editar la noticia
        echo "<a href='editar_noticia.php?id_noticia=" . $fila['id'] . "'>Editar</a>";
        // Botón para eliminar la noticia
        echo "<a href='eliminar_noticia.php?id_noticia=" . $fila['id'] . "'>Eliminar</a>";
        echo "</div>";
    }
} else {
    echo "No hay noticias para mostrar.";
}

echo "<a href='panel_admin.php'><button>Volver al inicio</button></a>";

// Cerrar la conexión
$conexion->close();
?>