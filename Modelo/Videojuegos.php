<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'credencialesBD.php';
/* Dentro de nuestro modelo, vamos a crear una función que nos comunique con la
base de datos para la obtención de los videojuegos y gracias a dicha función
comprobar si el videojuego que está iniciando sesión existe en dicha base de datos*/
function getVideojuegos($nombre){
    $conexion = createConection('ContenidosOcio');
    if(!$conexion){
        die('<br>Error en la conexión a la base de dato: ' . mysqli_connect_error());
    }
    $sql = "SELECT Nombre, Genero, Plataforma, Desarrolladora, FechaSalida FROM Videojuegos WHERE Nombre = '$nombre'";
    $result = mysqli_query($conexion, $sql);
    //Si la consulta obtiene valores, los obtenemos
    if(mysqli_num_rows($result) == 0){
        $result = false;
    }
    closeConection($conexion);
    return $result;
}