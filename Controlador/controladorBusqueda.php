<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../Modelo/Peliculas.php';
require_once '../Modelo/Series.php';
require_once '../Modelo/Videojuegos.php';

if (isset($_GET['termino'])) {
    $termino = trim($_GET['termino']);
    echo "<h3>📌 Término de búsqueda recibido: '{$termino}'</h3>";
    $peliculas = getPeliculas();
    $series = getSeries();
    $videojuegos = getVideojuegos();

    $resultados = [];

    //Buscamos en películas
    foreach ($peliculas as $peli) {
        if (stripos($peli['Nombre'], $termino) !== false) {
            $imagen =  "/TFG-DAW/Vista/imagenes/{$peli['Nombre']}.jpg";
            // Usamos urlencode para la ruta de la imagen, para que php lea bien los espacios en blanco
            $resultados[] = [
                "nombre" => $peli['Nombre'],
                "imagen" => $imagen,
                "tipo" => "Película",
                "genero" => $peli['Genero'],
                "duracion" => $peli['Duracion'],
                "fecha" => $peli['FechaEstreno']
            ];
        }
    }

    //Buscamos en series
    foreach ($series as $serie) {
        if (stripos($serie['Nombre'], $termino) !== false) {
            $imagen = "/TFG-DAW/Vista/imagenes/{$serie['Nombre']}.jpg";
            $resultados[] = [
                "nombre" => $serie['Nombre'],
                "imagen" => $imagen,
                "tipo" => "Serie",
                "genero" => $serie['Genero'],
                "temporadas" => $serie['Temporadas'],
                "capitulos" => $serie['Capitulos'],
                "fecha" => $serie['FechaEstreno']
            ];
        }
    }

    //Buscamos en videojuegos
    foreach ($videojuegos as $juego) {
        if (stripos($juego['Nombre'], $termino) !== false) {
            $imagen =  "/TFG-DAW/Vista/imagenes/{$juego['Nombre']}.jpg";
            $resultados[] = [
                "nombre" => $juego['Nombre'],
                "imagen" => $imagen,
                "tipo" => "Videojuego",
                "genero" => $juego['Genero'],
                "plataforma" => $juego['Plataforma'],
                "desarrolladora" => $juego['Desarrolladora'],
                "fecha" => $juego['FechaSalida']
            ];
        }
    }

    //Mostramos los resultados obtenidos
    echo "<h3>📌 Resultados de la búsqueda:</h3>";
    if (!empty($resultados)) {
        echo "<div id='resultadoBusqueda' class='resultados'>"; // Contenedor FLEX
        foreach ($resultados as $contenido) {
            echo "<div class='item'>
                    <img src='{$contenido['imagen']}' alt='{$contenido['nombre']}'>
                    <h3>{$contenido['nombre']}</h3>
                    <p><strong>Género:</strong> {$contenido['genero']}</p>
                    <p><strong>Fecha de estreno/lanzamiento:</strong> {$contenido['fecha']}</p>";

            // Añadir atributos específicos de cada tipo de contenido
            if ($contenido['tipo'] === "Película") {
                echo "<p><strong>Duración:</strong> {$contenido['duracion']} min</p>";
            } elseif ($contenido['tipo'] === "Serie") {
                echo "<p><strong>Temporadas:</strong> {$contenido['temporadas']}</p>
                    <p><strong>Capítulos:</strong> {$contenido['capitulos']}</p>";
            } elseif ($contenido['tipo'] === "Videojuego") {
                echo "<p><strong>Plataforma:</strong> {$contenido['plataforma']}</p>
                    <p><strong>Desarrolladora:</strong> {$contenido['desarrolladora']}</p>";
            }
            echo "</div>";
        }
        echo "</div>"; // Cierra el contenedor FLEX
    } else {
        echo "<p>❌ No hay contenidos relacionados con '$termino'.</p>";
    }
}
