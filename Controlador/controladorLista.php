<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../Modelo/Lista.php'; //Importamos el modelo que maneja las listas

//Verificamos si se recibió una acción desde el frontend
if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    /* Dado que existen varias funciones que realizan distintas acciones en relación a las listas,
    con un switch manejamos cada posible acción asociándola a un método del modelo */
    switch ($accion) {

        case 'obtenerListas':
            if (isset($_POST['usuarioID'])) {
                $usuarioID = $_POST['usuarioID'];
                $listas = getListasUsuario($usuarioID);
                echo json_encode($listas);
            } else {
                echo json_encode(["error" => "Falta el ID del usuario"]);
            }
            break;

        case 'crearLista':
            if (isset($_POST['usuarioID']) && isset($_POST['nombreLista'])) {
                $usuarioID = $_POST['usuarioID'];
                $nombreLista = $_POST['nombreLista'];
                $resultado = createLista($usuarioID, $nombreLista);
                echo json_encode(["mensaje" => $resultado]);
            } else {
                echo json_encode(["error" => "Faltan datos para crear la lista"]);
            }
            break;

        case 'eliminarLista':
            if (isset($_POST['NombreLista'])) {
                $nombreLista = $_POST['NombreLista'];
                $resultado = deleteLista($nombreLista);
                echo json_encode(["mensaje" => $resultado]);
            } else {
                echo json_encode(["error" => "Falta el nombre de la lista"]);
            }
            break;

        case 'agregarContenido':
            if (isset($_POST['idLista'], $_POST['idContenido'], $_POST['tipoContenido'])) {
                $idLista = $_POST['idLista'];
                $idContenido = $_POST['idContenido'];
                $tipoContenido = $_POST['tipoContenido'];
                $resultado = addContenidoLista($idLista, $idContenido, $tipoContenido);
                echo json_encode(["mensaje" => $resultado]);
            } else {
                echo json_encode(["error" => "Faltan datos para agregar contenido"]);
            }
            break;

        case 'eliminarContenido':
            if (isset($_POST['idLista'], $_POST['idContenido'])) {
                $idLista = $_POST['idLista'];
                $idContenido = $_POST['idContenido'];
                $resultado = deleteContenidoLista($idContenido, $idLista);
                echo json_encode(["mensaje" => $resultado]);
            } else {
                echo json_encode(["error" => "Faltan datos para eliminar contenido"]);
            }
            break;

        case 'obtenerContenidosDisponibles':
            if (isset($_POST['tipoContenido'])) {
                $tipo = $_POST['tipoContenido'];
                $contenidos = getContenidosPorTipo($tipo);
                echo json_encode($contenidos);
            } else {
                echo json_encode([]);
            }
            break;

        case 'obtenerContenidoLista':
            if (isset($_POST['idLista'])) {
                $idLista = $_POST['idLista'];
                $contenido = getContenidoLista($idLista);
                echo json_encode($contenido);
            } else{
                echo json_encode(["error" => "Falta el ID de la lista"]);
            }
            break;

        default:
            echo json_encode(["error" => "Acción no válida"]);
            break;
    }
} else {
    echo json_encode(["error" => "No se recibió ninguna acción"]);
}
