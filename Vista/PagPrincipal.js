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

}