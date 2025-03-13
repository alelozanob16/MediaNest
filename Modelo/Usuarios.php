<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'credencialesBD.php';
/* Dentro de nuestro modelo, vamos a crear una función que nos comunique con la 
base de datos para la obtención de los usuarios y gracias a dicha función 
comprobar si el usuario que está iniciando sesión existe en dicha base de datos*/
function getUsuarios($user, $pass){
    $conexion = createConection('ContenidosOcio');
    if(!$conexion){
        die('<br>Error en la conexión a la base de dato: ' . mysqli_connect_error());
    }
    $sql = "SELECT UserName, Rol, Pass FROM Usuarios WHERE UserName = '$user' AND Pass = '$pass'";
    $result = mysqli_query($conexion, $sql);
    //Si la consulta obtiene valores, los obtenemos
    if(mysqli_num_rows($result) > 0){
        $usuario = mysqli_fetch_assoc($result);
        closeConection($conexion);
        return $usuario;
    }else{
        closeConection($conexion);
        return false; //Si el usuario no existe, devolvemos false
    }
    
}

/*Creamos una función en la cual se compruebe que no existe un nombre igual al que
se esta registrando en la base de datos*/
function validateUser($username, $mail){
    $conexion = createConection('ContenidosOcio');
    if(!$conexion){
        die('<br>Error en la conexión a la base de dato: ' . mysqli_connect_error());
    }
    $sql = "SELECT UserName, Email FROM Usuarios WHERE UserName = '$username' AND Email = '$mail'";
    $result = mysqli_query($conexion, $sql);
    $usuarioExiste = mysqli_num_rows($result) > 0; /* Si recibimos más de 0 filas, es que el usuario y el correo
    estan en uso*/
    closeConection( $conexion);
    return !$usuarioExiste; /*Esto devolverá true si el usuario no existe y false si el usuario existiese*/
}

/*La función createUser la hemos creado en pos de poder insertar usuarios en la base de datos 
con los datos que le pasemos*/ 
function createUser($username, $mail, $pass){
    $conexion = createConection('ContenidosOcio');
    if(!$conexion){
        die('<br>Error en la conexión a la base de datos: ' . mysqli_connect_error());
    }
    $sql = "INSERT INTO Usuarios (UserName, Email, Pass) VALUES ('$username', '$mail', '$pass')";
    $result = mysqli_query($conexion, $sql);
    if(mysqli_affected_rows($conexion) == 0){
    }
    closeConection($conexion);
    return $result;
}