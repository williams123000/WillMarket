<?php
// PHP para actualizar un producto en la base de datos.
//
// Incluir el archivo de conexión a la base de datos
require_once 'conexion.php';

// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtener los datos del formulario
    $Id = $_POST['Id'];
    $Nombre = $_POST['Nombre'];
    $Descripcion = $_POST['Descripcion'];
    $Precio = $_POST['Precio'];

    // Preparar la consulta SQL para actualizar el producto
    $sql = "UPDATE productos SET ";
    // Inicializar un array para almacenar los parámetros y un string para los tipos de datos de los parámetros
    $params = array();
    // Inicializar un string para los tipos de datos de los parámetros
    $types = '';

    // Verificar qué campos se están actualizando y construir la consulta en consecuencia
    if (!empty($Nombre)) {
        // Agregar el campo Nombre a la consulta
        $sql .= "Nombre = ?, ";
        // Agregar el valor del campo Nombre a los parámetros y especificar el tipo de dato (s = string)
        $params[] = &$Nombre;
        $types .= 's';
    }
    if (!empty($Descripcion)) {
        $sql .= "Descripcion = ?, ";
        $params[] = &$Descripcion;
        $types .= 's';
    }
    if (!empty($Precio)) {
        $sql .= "Precio = ?, ";
        $params[] = &$Precio;
        $types .= 'd';
    }

    // Eliminar la coma y el espacio extra al final de la consulta
    $sql = rtrim($sql, ", ");

    // Agregar la condición WHERE para el Id
    $sql .= " WHERE Id = ?";
    // Agregar el Id a los parámetros y especificar el tipo de dato (i = integer) 
    $params[] = &$Id;
    // Agregar el tipo de dato del Id a la lista de tipos
    $types .= 'i';

    // Preparar la declaración y enlazar los parámetros
    $statement = $conexion->prepare($sql);

    // Si hay al menos un campo para actualizar, ejecutar la consulta
    if (!empty($params)) {
        // Agregar los tipos de datos de los parámetros
        $statement->bind_param($types, ...$params);

        // Ejecutar la consulta
        if ($statement->execute()) {
            // Producto actualizado con éxito
            header("Location: ../index_admin.html");
            exit(); // Asegura que el script se detenga después de la redirección
        } else {
            // Error al actualizar el producto
            echo "Error al actualizar el producto: " . $conexion->error;
        }
    } else {
        // No hay campos para actualizar
        echo "No se han proporcionado campos para actualizar.";
    }

    // Cerrar la declaración y la conexión a la base de datos
    $statement->close();
    $conexion->close();
}
?>
