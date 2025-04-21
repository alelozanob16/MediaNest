<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'credencialesBD.php';

/*Obtenemos las todas las listas de los usuarios para mostrarselas
al usuario*/
function getListasUsuario($usuarioID) {
    $conexion = createConection('ContenidosOcio');
    if (!$conexion) {
        die('<br>Error en la conexión a la base de datos: ' . mysqli_connect_error());
    }
    $sql = "SELECT ID, NombreLista FROM ListasMultimedia WHERE UsuarioID = '$usuarioID'";
    $result = mysqli_query($conexion, $sql);
    $listas = [];
    while ($lista = mysqli_fetch_assoc($result)) {
        $listas[] = $lista;
    }
    closeConection($conexion);
    return $listas;
}

//Obtenemos el contenido de una lista concreta para mostrarle dicho contenido al usuario.
function getContenidoLista($idLista) {
    $conexion = createConection('ContenidosOcio');
    if (!$conexion) {
        die('<br>Error en la conexión a la base de datos: ' . mysqli_connect_error());
    }
    $sql = "SELECT cl.IDContenido, cl.TipoContenido, 
                   CASE 
                       WHEN cl.TipoContenido = 'Pelicula' THEN (SELECT Nombre FROM Peliculas WHERE ID = cl.IDContenido)
                       WHEN cl.TipoContenido = 'Serie' THEN (SELECT Nombre FROM Series WHERE ID = cl.IDContenido)
                       WHEN cl.TipoContenido = 'Videojuego' THEN (SELECT Nombre FROM Videojuegos WHERE ID = cl.IDContenido)
                   END AS Nombre
            FROM ContenidoLista cl
            WHERE cl.IDLista = '$idLista'";
    /*Con esta consulta sql, obtenemos los nombres de los contenidos en base al tipo y su ID
    dado que en esta tabla no existe un atributo con el nombre*/
    $result = mysqli_query($conexion, $sql);
    $contenido = [];
    while ($item = mysqli_fetch_assoc($result)) {
        $contenido[] = $item;
    }
    closeConection($conexion);
    return $contenido;
}

//Hacemos una función que permita al usuario crear su propia lista
function createLista($usuarioID, $nombreLista){
    $conexion = createConection('ContenidosOcio');
    if (!$conexion) {
        die('<br>Error en la conexión a la base de datos: ' . mysqli_connect_error());
    }
    //Insertamos la nueva lista con su nombre asociada al usuario que lo ha creado
    $sql = "INSERT INTO ListasMultimedia (NombreLista, UsuarioID) VALUES ('$nombreLista', '$usuarioID')";
    $result = mysqli_query($conexion, $sql);
    if($result){
        $mensaje = "Lista creada correctamente";
    }else{
        $mensaje = "No ha sido posible crear la lista de manera correcta";
    }
    closeConection($conexion);
    return $mensaje;
}

function deleteLista($nombreLista){
    $conexion = createConection('ContenidosOcio');
    if (!$conexion) {
        die('<br>Error en la conexión a la base de datos: ' . mysqli_connect_error());
    }
    $sql = "DELETE FROM ListasMultimedia WHERE NombreLista = '$nombreLista'";
    $result = mysqli_query($conexion, $sql);
    if($result){
        $mensaje = "Lista eliminada correctamente";
    }else{
        $mensaje = "No ha sido posible eliminar la lista de manera correcta";
    }
    closeConection($conexion);
    return $mensaje;
}

//Función para que podamos agregar contenido a una lista
function addContenidoLista($idLista, $idContenido, $tipoContenido) {
    $conexion = createConection('ContenidosOcio');
    if (!$conexion) {
        die('<br>Error en la conexión a la base de datos: ' . mysqli_connect_error());
    }

    //Verificamos si el contenido ya está en la lista y que no haya duplicados
    $sqlCheck = "SELECT * FROM ContenidoLista WHERE IDLista = '$idLista' AND IDContenido = '$idContenido' AND TipoContenido = '$tipoContenido'";
    $resultCheck = mysqli_query($conexion, $sqlCheck);

    if (mysqli_num_rows($resultCheck) > 0) {
        closeConection($conexion);
        return "El contenido ya está en la lista.";
    }

    //Agregamos contenido a la lista después de verificar que no está previamente en la lista
    $sql = "INSERT INTO ContenidoLista (IDLista, IDContenido, TipoContenido) VALUES ('$idLista', '$idContenido', '$tipoContenido')";
    $result = mysqli_query($conexion, $sql);
    if ($result) {
        $mensaje = "Contenido agregado correctamente.";
    } else {
        $mensaje = "Error al agregar el contenido.";
    }
    closeConection($conexion);
    return $mensaje;
}

function deleteContenidoLista($idContenido, $idLista){
    $conexion = createConection('ContenidosOcio');
    if (!$conexion) {
        die('<br>Error en la conexión a la base de datos: ' . mysqli_connect_error());
    }
    $sql = "DELETE FROM ContenidoLista WHERE IDLista = '$idLista' AND IDContenido = '$idContenido'";
    $result = mysqli_query($conexion, $sql);
    if($result){
        $mensaje = "Contenido eliminado con éxito";
    }else{
        $mensaje = "Error al eliminar el contenido";
    }
    closeConection($conexion);
    return $mensaje;   
}

/*Esta función la usamos para poder rescatar los contenidos por tipos y que los usuarios, más adelante,
puedan añadir dichos contenidos filtrados*/
function getContenidosPorTipo($tipoContenido) {
    $conexion = createConection('ContenidosOcio');
    if (!$conexion) {
        die('Error en la conexión a la base de datos: ' . mysqli_connect_error());
    }

    switch ($tipoContenido) {
        case 'Pelicula':
            $sql = "SELECT ID, Nombre FROM Peliculas";
            break;
        case 'Serie':
            $sql = "SELECT ID, Nombre FROM Series";
            break;
        case 'Videojuego':
            $sql = "SELECT ID, Nombre FROM Videojuegos";
            break;
        default:
            return [];
    }

    $result = mysqli_query($conexion, $sql);
    $contenidos = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $contenidos[] = $row;
    }

    closeConection($conexion);
    return $contenidos;
}
