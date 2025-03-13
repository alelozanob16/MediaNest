<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'credencialesBD.php';
/* Dentro de nuestro modelo, vamos a crear una función que nos comunique con la
base de datos para la obtención de las películas y gracias a dicha función
comprobar si la película que está iniciando sesión existe en dicha base de datos*/
function getPeliculas($nombre){
    $conexion = createConection('ContenidosOcio');
    if(!$conexion){
        die('<br>Error en la conexión a la base de dato: ' . mysqli_connect_error());
    }
    $sql = "SELECT Nombre, Genero, Duracion, FechaEstreno FROM Peliculas WHERE Nombre = '$nombre'";
    $result = mysqli_query($conexion, $sql);
    //Si la consulta obtiene valores, los obtenemos
    if(mysqli_num_rows($result) == 0){
        $result = false;
    }
    closeConection($conexion);
    return $result;
}