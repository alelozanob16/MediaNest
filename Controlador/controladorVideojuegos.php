<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../Modelo/Videojuegos.php';
/* Lo que hacemos en el controlador de los videojuegos es guardar los datos obtenidos por la función
getVideojugos() en una variable.*/
$juegos = getVideojuegos();
// Devolver los juegos como JSON, los recuperaremos usando AJAX combinado con jQuery.
echo json_encode($juegos);