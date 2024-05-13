<?php
// php para agregar un producto a la base de datos y redirigir a la página de administración de productos si se agrega correctamente 
//o mostrar un mensaje de error si no se agrega correctamente el producto. 

// Incluir el archivo de conexión a la base de datos
require_once 'conexion.php';

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];

    // Obtener el contenido del archivo de imagen
    $imagen_temporal = $_FILES['imagen']['tmp_name'];
    // Leer el contenido del archivo de imagen en binario para almacenarlo en la base de datos
    $imagen_contenido = file_get_contents($imagen_temporal);

    // Preparar la consulta SQL para insertar los datos en la base de datos
    $sql = "INSERT INTO productos (nombre, descripcion, precio, categoria, imagen) VALUES (?, ?, ?, ?, ?)";

    // Preparar la declaración y enlazar los parámetros
    $statement = $conexion->prepare($sql);
    // Especificar los tipos de datos de los parámetros (s = string, d = double) 
    $statement->bind_param("ssdss", $nombre, $descripcion, $precio, $categoria, $imagen_contenido);

    // Ejecutar la declaración
    if ($statement->execute()) {
        header("Location: ../index_admin.html");
        exit(); // Asegura que el script se detenga después de la redirección
    } else {
        echo "Error al agregar el producto: " . $conexion->error;
    }

    // Cerrar la declaración y la conexión a la base de datos
    $statement->close();
    $conexion->close();
    // Después de que se haya insertado el nuevo producto correctamente:

}
