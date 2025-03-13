<?php
define("host", "127.0.0.1");
define("user", "root");
define("password", "root1234");

/* Establecemos una función que sea capaz de crear conexiones a bases de datos. */
function createConection($database_name){
    //Probamos primero en local.
    $conexion = mysqli_connect(host, user, password, $database_name);
    if(!$conexion){
        //Si no se ha podido conectar a la base de datos local, probamos en el servidor.
        $conexion = mysqli_connect(host, user, password, 'if0_37956321_' . $database_name);
        //Si hay un error en la conexion lo mostramos.
        if(!$conexion){
            die("<br>Error en la conexión a la base de datos: " . mysqli_connect_error());
        }
    
    }
    return $conexion;
}
//Establecemos una función que cierra, por defecto, cualquier conexion con una base de datos.
function closeConection($conexion){
    mysqli_close($conexion);
}


