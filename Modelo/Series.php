<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'credencialesBD.php';
/* Dentro de nuestro modelo, vamos a crear una función que nos comunique con la
base de datos para la obtención de los videojuegos*/
function getSeries(){
    $conexion = createConection('ContenidosOcio');
    if(!$conexion){
        die('<br>Error en la conexión a la base de dato: ' . mysqli_connect_error());
    }
    $sql = "SELECT * FROM Series";
    $result = mysqli_query($conexion, $sql);
    //Mostramos los videojuegos que hay en la base de datos con sus campos
    $series = [];//Creamos un array vacío para que se vaya llenando a medida que se consulta la bbdd
    while($serie = mysqli_fetch_assoc($result)){
        $series[] = $serie;
    }
    closeConection($conexion);
    return $series;
}