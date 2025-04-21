<?php
/*Lo que hacemos aquí es que si existe una sesion, la destruimos y si no existe sesion, pero se hace click 
le decimos que no hay sesion iniciada*/
session_start();
if(!isset($_SESSION['Username'])){
    echo "<script>alert('No hay una sesión iniciada.'); 
    window.location.href = '../index.html';
    </script>";
    exit();
}
session_destroy();
echo "<script>
            alert('Sesión cerrada con éxito');
            window.location.href = '../index.html';
        </script>";
exit();