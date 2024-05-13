<?php
// PHP para validar el inicio de sesión de un usuario y redirigir a la página de administración de productos si las credenciales son válidas
// o redirigir al formulario de inicio de sesión con un mensaje de error si las credenciales son inválidas.


// Iniciar la sesión para mantener la información del usuario autenticado en todas las páginas del sitio web-
session_start();

// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombre_usuario = $_POST['username'];
    $password_usuario = $_POST['password'];

    // Conectar con la base de datos
    include 'conexion.php';
    // Consultar el usuario en la base de datos y verificar la contraseña
    $sql = "SELECT * FROM usuarios WHERE Nombre = ? AND Pass = ?";
    // Preparar la declaración y enlazar los parámetros de nombre y contraseña a la consulta SQL
    $statement = $conexion->prepare($sql);
    // Especificar el tipo de dato de los parámetros (s = string)
    $statement->bind_param("ss", $nombre_usuario, $password_usuario);
    // Ejecutar la consulta
    $statement->execute();
    // Obtener los resultados
    $resultado = $statement->get_result();

    if ($resultado->num_rows > 0) {
        // Si se encuentra un usuario con el nombre y contraseña proporcionados
        // Contraseña válida, iniciar sesión y redirigir a la página de administración de productos
        $_SESSION['nombre_usuario'] = $nombre_usuario;
        header("Location: ../index_admin.html");
    } else {
        // Usuario no encontrado o contraseña incorrecta
        // Redirigir de nuevo al formulario de inicio de sesión con un mensaje de error
        header("Location: ../index.html?error=credenciales_invalidas");
    }

    // Cerrar la conexión a la base de datos
    $statement->close();
    $conexion->close();
} else {
    // Si no se enviaron datos por POST, redirigir de nuevo al formulario de inicio de sesión
    header("Location: index.html");
}
?>
