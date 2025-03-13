<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../Modelo/Usuarios.php';
/*En este punto lo que hacemos es controlar que, cuando se cree un usuario nuevo,
no exista previamente el usuario. Es importante destacar que se creará con los datos
que se pasan por el formulario.*/

// Comprobar si los datos del formulario han sido enviados por POST
if (isset($_POST['username']) && isset($_POST['mail']) && isset($_POST['pass'])) {

    // Recuperamos los datos enviados a través del formulario
    $username = $_POST['username'];
    $mail = $_POST['mail'];
    $pass = $_POST['pass'];

    // Depuración: Verificamos si los datos están siendo enviados correctamente
    echo "Datos recibidos:<br>";
    echo "Usuario: " . htmlspecialchars($username) . "<br>";
    echo "Correo: " . htmlspecialchars($mail) . "<br>";
    echo "Contraseña: " . htmlspecialchars($pass) . "<br>";

    // Validar si el usuario ya existe
    $usuarioValido = validateUser($username, $mail);

    echo "Validación del usuario: " . ($usuarioValido ? "El usuario no existe" : "El usuario ya existe") . "<br>";

    if ($usuarioValido) {
        // Si el usuario no existe, intentamos crearlo
        $result = createUser($username, $mail, $pass);

        // Depuración: Verificamos si la inserción en la base de datos fue exitosa
        if ($result) {
            echo "El usuario fue creado con éxito.<br>";
            // Si el registro fue exitoso, redirigimos a la página de inicio de sesión
            header('Location: ../Vista/iniciaSesion.html');
            exit();
        } else {
            // Si ocurrió un error en la inserción, mostramos un mensaje de error
            echo "Error en la inserción del usuario en la base de datos.<br>";
            echo "Consulta de inserción: " . $sql . "<br>"; // Mostrar la consulta SQL si hay un problema
        }
    } else {
        // Si el usuario ya existe, mostramos un mensaje de error
        echo "<p>El usuario o el correo electrónico ya están en uso. Por favor, usa otro nombre o correo.</p>";
    }
} else {
    // Si no se han recibido los datos del formulario, mostramos un mensaje de error
    echo "<p>Error: No se han recibido los datos del formulario.</p>";
}
