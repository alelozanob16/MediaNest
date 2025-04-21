window.onload = function(){
    //Redireccionamos a X cuando se clique en su simbolo
    $('#twitter').click(function(){
        window.location.href = "https://x.com/?lang=es";
    })

    //Redireccionamos a Instagram cuando se clique en su simbolo
    $('#insta').click(function(){
        window.location.href = "https://www.instagram.com/";
    });

    //Redireccionamos a Facebook cuando se clique en su simbolo
    $('#facebook').click(function(){
        window.location.href = "https://www.facebook.com/?locale=es_ES";
    });

    //Redireccionamos a TikTok cuando se clique en su simbolo
    $('#tiktok').click(function(){
        window.location.href = "https://www.tiktok.com/explore";
    });

    //LLevamos a la página de inicio de sesión
    $('#iniciarSesion').click(function(){
        window.location.href = "Vista/iniciaSesion.html";
    });

    //Llevamos a la página de series
    $('#series').click(function(){
        window.location.href = "Vista/Series.html";
    });

    //Llevamos a la página de videojuegos
    $('#juegos').click(function(){
        window.location.href = "Vista/Videojuegos.html";
    });

    //Llevamos a la página de películas
    $('#pelis').click(function(){
        window.location.href = "Vista/Peliculas.html";
    });

    /*Cuando un usuario hace click en cerrar sesión lo mandamos al controlador para que lo maneje en base
    a si ha iniciado sesión o no*/
    $(document).ready(function() {
        $('#cerrarSesion').click(function() {
            window.location.href = 'Controlador/controladorCerrarSesion.php'; //Redirigimos al script de cierre de sesión
        });
    });

    /*Llevamos a la página de las listas si esta registrado, pero si no ha iniciado sesion se le lleva
    a la página. Para ello nos traemos los datos de sesion, si se ha iniciado, del controlador
    de inicio de sesion*/ 
    $(document).ready(function() {
        $('#listas').click(function() {
            $.ajax({
                url: 'Controlador/controladorInicioSesion.php',
                method: 'GET',
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.estado === '1') {
                        window.location.href = "Vista/Listas.html";//Si hay una sesión, llevamos al usuario a la página de listas
                    } else {
                        window.location.href = "Vista/iniciaSesion.html"; // Si no, ir al inicio de sesión
                    }
                }
            });
        });
    });

    //Hacemos una función anonima para que al pulsar enter se realice la búsqueda
    $('#busqueda').keypress(function(e){
        if(e.which == 13){
            realizarBusqueda();
        }
    });

    /*En este bloque lo que vamos a hacer es darle la funcionalidad real de búsqueda al menú de
    búsqueda del index*/
    $(document).ready(function(){
        $('#botonBusqueda').click(function(){
            realizarBusqueda();
        }
    )  
    });

    function realizarBusqueda(){
        $("#botonBusqueda").click(function() {
            let consulta = $("#textoBusqueda").val().trim(); // Obtener el texto de búsqueda
    
            if (consulta === "") {
                $("#resultadoBusqueda").html("<p>Por favor, ingresa un término de búsqueda.</p>");
                return;
            }
    
            $.get('/TFG-DAW/Controlador/controladorBusqueda.php', { termino: consulta }, function(respuesta) {
                $("#resultadoBusqueda").html(respuesta);
            })
            .fail(function() {
                $("#resultadoBusqueda").html("<p>Error al realizar la búsqueda.</p>");
            });
        });
    };
}