<?php
// PHP para consultar productos de una categoría específica y mostrar los resultados en formato JSON 
// para ser utilizados en una aplicación web. 

// Incluye el archivo de conexión a la base de datos
include 'conexion.php';

// Verificar si se proporcionó la categoría como parámetro
if(isset($_GET['categoria'])) {
    $categoria = $_GET['categoria'];
    
    // Realizar la consulta SQL con la categoría proporcionada
    $sql = "SELECT Id, Nombre, Descripcion, Precio, Categoria, Imagen FROM productos WHERE Categoria = ?";
    // Preparar la declaración y enlazar el parámetro de la categoría a la consulta SQL 
    $stmt = $conexion->prepare($sql);
    // Especificar el tipo de dato de la categoría (s = string)
    $stmt->bind_param("s", $categoria);
    // Ejecutar la consulta
    $stmt->execute();
    // Obtener los resultados
    $resultado = $stmt->get_result();

    // Almacenar los datos de productos en un array
    $rows = array();
    while($row = $resultado->fetch_assoc()) {
        // Convertir la imagen a base64
        $imagen_binaria = $row['Imagen'];
        $imagen_base64 = base64_encode($imagen_binaria);
        
        // Reemplazar la imagen binaria por la imagen base64 en los datos del producto
        $row['Imagen'] = $imagen_base64;
    
        // Agregar el producto al array de datos
        $rows[] = $row;
    }

    // Retornar los datos de productos en formato JSON
    echo json_encode($rows);
} else {
    // Si no se proporciona la categoría, retorna un mensaje de error
    echo "Error: No se proporcionó la categoría.";
}
?>
