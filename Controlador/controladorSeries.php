<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../Modelo/Series.php';
/* Lo que hacemos en el controlador de las series es guardar los datos obtenidos por la función
getSeries() en una variable.*/
$series = getSeries();
// Devolver las series como JSON, las recuperaremos usando AJAX combinado con jQuery.
echo json_encode($series);