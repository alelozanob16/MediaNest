<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'credencialesBD.php';
/*Usamos este modelo para que un administrador pueda eliminar contenido al entrar al apartado de
peliculas, series o videojuegos*/
function eliminarPeliculas($id){
    $conexion = createConection('ContenidosOcio');
    if(!$conexion){
        die('<br>Error en la conexión a la base de dato: ' . mysqli_connect_error());
    }
    $sql = "DELETE FROM Peliculas WHERE ID = '$id'";
    $result = mysqli_query($conexion, $sql);
    if($result){
        $mensaje = "Película eliminada con éxito";
    }else{
        $mensaje = "No ha sido posible eliminar la película";
    }
    closeConection($conexion);
    return $mensaje;
}

function eliminarSeries($id){
    $conexion = createConection('ContenidosOcio');
    if(!$conexion){
        die('<br>Error en la conexión a la base de dato: ' . mysqli_connect_error());
    }
    $sql = "DELETE FROM Series WHERE ID = '$id'";
    $result = mysqli_query($conexion, $sql);
    if($result){
        $mensaje = "Serie eliminada con éxito";
    }else{
        $mensaje = "No ha sido posible eliminar la serie";
    }
    closeConection($conexion);
    return $mensaje;
}

function eliminarVideojuegos($id){
    $conexion = createConection('ContenidosOcio');
    if(!$conexion){
        die('<br>Error en la conexión a la base de dato: ' . mysqli_connect_error());
    }
    $sql = "DELETE FROM Videojuegos WHERE ID = '$id'";
    $result = mysqli_query($conexion, $sql);
    if($result){
        $mensaje = "Videojuego eliminado con éxito";
    }else{
        $mensaje = "No ha sido posible eliminar el videojuego";
    }
    closeConection($conexion);
    return $mensaje;
}