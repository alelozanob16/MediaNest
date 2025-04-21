<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Importamos las funciones de eliminación del modelo
require_once '../Modelo/Admin.php';

//Verificamos que se haya recibido una solicitud POST con los datos necesarios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID'], $_POST['Tipo'])) {
    $id = $_POST['ID'];
    $tipo = $_POST['Tipo'];

    switch ($tipo) {
        case 'Pelicula':
            $mensaje = eliminarPeliculas($id);
            break;
        case 'Serie':
            $mensaje = eliminarSeries($id);
            break;
        case 'Videojuego':
            $mensaje = eliminarVideojuegos($id);
            break;
        default:
            $mensaje = "Tipo de contenido no válido";
            break;
    }

    echo $mensaje;
} else {
    echo "Datos insuficientes para realizar la operación";
}
