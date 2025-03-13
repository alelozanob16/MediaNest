<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../Modelo/Usuarios.php';

/*Aquí lo que hacemos es comprobar que el usuario que inicia sesión es un
usuario registrado en la base de datos y por lo tanto su inicio de sesión es válido.*/
if(isset($_POST['user']) && isset($_POST['password'])){
    loginValidate($_POST['user'], $_POST['password']);
}
function loginValidate($user, $pass){
    $result = getUsuarios($user, $pass);
    if($result){
        session_start();
        $_SESSION['Rol'] = $result['Rol'];
        $_SESSION['Username'] = $result['UserName'];
        header('Location: ../index.html'); //Tras un login existoso, 
    }else{
        "<p>Error: Usuario o contraseña incorrectos.</p>";
    }
}
