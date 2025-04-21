<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../Modelo/Usuarios.php';

/*Aquí lo que hacemos es comprobar que el usuario que inicia sesión es un
usuario registrado en la base de datos y por lo tanto su inicio de sesión es válido.*/
if (isset($_POST['user']) && isset($_POST['password'])) {
    loginValidate($_POST['user'], $_POST['password']);
}

/*Ayudandonos de la función getUsuarios() comprobamos que haya un usuario
real y que coincida con el que ha sido introducido*/
function loginValidate($user, $pass) {
    $result = getUsuarios($user, $pass);
    if ($result) {
        session_start();
        $_SESSION['Rol'] = $result['Rol'];
        $_SESSION['Username'] = $result['UserName'];
        $_SESSION['ID'] = $result['ID'];

        // Devuelvo una alerta para que el usuario sepa que ha iniciado sesión
        echo "<script>
                alert('Sesión iniciada con éxito');
                window.location.href = '../index.html';
              </script>";
    } else {
        echo "<p>Error: Usuario o contraseña incorrectos.</p>";
    }
}

/*Esta parte es importante: la usamos cuando hacemos una petición GET desde el JavaScript.
Queremos saber si ya hay una sesión iniciada, y si existe, devuelvo 1 (true), si no, devuelvo 0 (false)*/
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    session_start();
    if (isset($_SESSION['Username'])) {
        echo json_encode([
            'estado' => '1',  // Sesión activa
            'usuarioID' => $_SESSION['ID'],  // El usuarioID guardado en la sesión
            'Rol' => $_SESSION['Rol']  //El rol guardado en la sesión, nos servirá para el adminisrador
        ]);
    } else {
        echo json_encode([
            'estado' => '0'  // No hay sesión activa
        ]);
    }
    exit(); //Termina el script después de enviar la respuesta JSON
}
