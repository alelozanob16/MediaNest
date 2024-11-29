window.onload = function(){
    console.log('Página cargada');

    const imagenes = [
        'imagenes/libros.png', // Ruta local
        'imagenes/videojuegos.png', // Ruta local
        'imagenes/series.png', // Ruta local
        'imagenes/peliculas.png' // Ruta local
    ];

    const tiempoFotos = 1500;
    var posicionActual = 0;
    var botonRetroceder = document.querySelector('#retroceder');
    var botonAvanzar = document.querySelector('#avanzar');
    var imagen = document.querySelector('#imagen');
    var botonPlay = document.querySelector('#play');
    var botonStop = document.querySelector('#stop');
    var intervalo;

    function pasarFoto() {
        if (posicionActual >= imagenes.length - 1) {
            posicionActual = 0;
        } else {
            posicionActual++;
        }
        renderizarImagen();
    }

    function retrocederFoto() {
        if (posicionActual <= 0) {
            posicionActual = imagenes.length - 1;
        }else{
            posicionActual--;
        }
        renderizarImagen();
    }

    function renderizarImagen() {
        console.log(`Cargando imagen: ${imagenes[posicionActual]}`);
        imagen.style.backgroundImage = `url(${imagenes[posicionActual]})`;
    }

    function playIntervalo() {
        intervalo = setInterval(pasarFoto, tiempoFotos);
        botonAvanzar.setAttribute('disabled', true);
        botonRetroceder.setAttribute('disabled', true);
        botonStop.removeAttribute('disabled');
        botonPlay.setAttribute('disabled', true);
    }

    function stopIntervalo() {
        clearInterval(intervalo);
        botonAvanzar.removeAttribute('disabled');
        botonPlay.removeAttribute('disabled');
        botonRetroceder.removeAttribute('disabled');
        botonStop.setAttribute('disabled', true);
    }

    botonAvanzar.addEventListener('click', pasarFoto);
    botonRetroceder.addEventListener('click', retrocederFoto);
    botonPlay.addEventListener('click', playIntervalo);
    botonStop.addEventListener('click', stopIntervalo);

    renderizarImagen();
};
