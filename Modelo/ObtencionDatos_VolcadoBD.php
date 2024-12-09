<?php
require_once 'Modelo/credencialesBD.php';
/* Vamos a definir la url de la api con nuestras credenciales */
const apiKey = "765c4e3d90a4da35a6a4c5705e690ed7";
const urlPelis = "https://api.themoviedb.org/3/movie/popular?api_key={$apiKey}&language=es";
const urlSeries = "https://api.themoviedb.org/3/tv/popular?api_key={$apiKey}&language=es";

/*Generamos una función que haga una consulta a la api predeterminada */
function conseguirDatosAPI($url){
    // Iniciamos una sesión a través de un manejador de curl(librería de PHP que permite las peticiones por HTTP).
    $curl = curl_init();
    //Especificamos la URL de destino de la solicitud que vamos a hacer.
    curl_setopt($curl, CURLOPT_URL, $url);
    /* En lugar de mostrar el json, queremos que la respuesta(dicho json) se guarde
    en pos de trabajar con ella y transformar su formato más adelante. */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // Ejecutamos la solicitud que hemos configurado antes con curl_setop.
    $response = curl_exec($curl);
    // Cerramos la sesión basada en el manejador previamente definido.
    curl_close($curl);
    /* Transformamos el tipo de la respuesta, es decir convertimos el json en un array
    asociativo (podría ser un objeto, pero si establecemos el parámetro booleano de la función json_decode
    en true, haremos que se convierta en un array asociativo). */
    return json_decode($response, true);
}
$datosPeliculas = conseguirDatosAPI($urlPelis);
$datosSeries = conseguirDatosAPI($urlSeries);

/* Establecemos una función que sea capaz de crear conexiones a bases de datos. */
function crearConexion($database_name){
    $conexion = mysqli_connect(host, user, password, $database_name);
    //Si hay un error en la conexion lo mostramos.
    if(!$conexion){
        die("<br>Error en la conexión a la base de datos: " . mysqli_connect_error());
    }
}

//Establecemos una función que cierra, por defecto, cualquier conexion con una base de datos.
function cerrarConexion($conexion){
    mysqli_close($conexion);
}

