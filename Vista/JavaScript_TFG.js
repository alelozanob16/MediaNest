window.onload = function(){
    let x = document.querySelector('#twitter');
    let insta = document.querySelector('#insta');
    let facebook = document.querySelector('#facebook');
    let tiktok = document.querySelector('#tiktok');
    let botonBuscar = document.querySelector('#botonBusqueda');

    //Redireccionamos a X cuando se clique en su simbolo
    x.addEventListener('click', function(){
        window.location.href = "https://x.com/?lang=es";
    }, false)

    insta.addEventListener('click', function(){
        window.location.href = "https://www.instagram.com/";
    }, false);

    facebook.addEventListener('click', function(){
        window.location.href = "https://www.facebook.com/?locale=es_ES";
    }, false);

    tiktok.addEventListener('click', function(){
        window.location.href = "https://www.tiktok.com/explore";
    }, false);
}