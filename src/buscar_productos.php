<?php
// php para buscar productos dentro de un rango de precios y mostrar los resultados en la página web. 

// Verificar si se enviaron los rangos de precios
if (isset($_GET['precio_min']) && isset($_GET['precio_max'])) {
    // Obtener los rangos de precios desde el formulario
    $precio_min = $_GET['precio_min'];
    $precio_max = $_GET['precio_max'];
    echo "<h2>Buscando productos entre $" . $precio_min . " y $" . $precio_max . "</h2>";
    
    // Realizar la conexión a la base de datos
    include 'conexion.php';

    // Preparar la consulta SQL para seleccionar los productos dentro del rango de precios
    $sql = "SELECT * FROM productos WHERE Precio BETWEEN ? AND ?";
    // Preparar la declaración y enlazar los parámetros de los rangos de precios a la consulta
    $statement = $conexion->prepare($sql);
    // Especificar los tipos de datos de los parámetros (d = double) 
    $statement->bind_param("dd", $precio_min, $precio_max);
    // Ejecutar la consulta
    $statement->execute();
    // Obtener los resultados
    $resultado = $statement->get_result();

    // Mostrar los resultados
    if ($resultado->num_rows > 0) {
        echo "<h2>Resultados de la búsqueda:</h2>";
        echo "<ul>";
        while ($fila = $resultado->fetch_assoc()) {
            echo "<li>" . $fila['Nombre'] . " - $" . $fila['Precio'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "No se encontraron productos dentro de ese rango de precios.";
    }

    // Cerrar la conexión
    $conexion->close();
} else {
    // Si no se enviaron los rangos de precios, redirigir a otra página o mostrar un mensaje de error
    echo "Error: Se deben especificar los rangos de precios.";
}
?>
