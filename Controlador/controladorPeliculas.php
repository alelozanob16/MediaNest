<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../Modelo/Peliculas.php';
/* Lo que hacemos en el controlador de las películas es guardar los datos obtenidos por la función
getPeliculas() en una variable.*/
$peliculas = getPeliculas();
// Devolver las películas como JSON, las recuperaremos usando AJAX.
echo json_encode($peliculas);