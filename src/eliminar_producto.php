<?php
// PHP para eliminar un producto de la base de datos y redirigir a la página de administración de productos si se elimina correctamente
// o mostrar un mensaje de error si no se elimina correctamente el producto. 

// Verificar si se recibió el ID del producto a eliminar
if(isset($_POST['id_eliminar'])) {
    // Obtener el ID del producto
    $id_eliminar = $_POST['id_eliminar'];

    // Realizar la conexión a la base de datos
    include 'conexion.php';

    // Preparar la consulta SQL para eliminar el producto
    $sql = "DELETE FROM productos WHERE Id = ?";
    // Preparar la declaración y enlazar el parámetro del ID a la consulta SQL
    $statement = $conexion->prepare($sql);
    // Especificar el tipo de dato del ID (i = integer)
    $statement->bind_param("i", $id_eliminar);
    
    // Ejecutar la consulta
    if($statement->execute()) {
        // Producto eliminado con éxito
        header("Location: ../index_admin.html");
        exit(); // Asegura que el script se detenga después de la redirección
    } else {
        // Error al eliminar el producto
        echo "Error al eliminar el producto: " . $conexion->error;
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
} else {
    // No se recibió el ID del producto a eliminar
    echo "Debe proporcionar el ID del producto a eliminar.";
}
?>
