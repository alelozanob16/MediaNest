$(document).ready(function () {
    let usuarioID = null;

    /*Lo primero que hacemos es traer el usuario que ha iniciado sesión, para saber
    qué usuario está creando, eliminando o viendo sus listas. Si no hay sesión, lo
    redirigimos al login.*/
    $.ajax({
        url: '../Controlador/controladorInicioSesion.php',
        method: 'GET',
        success: function (response) {
            console.log("Respuesta de controladorInicioSesion.php:", response);
            const data = JSON.parse(response);
    
            if (data.estado === '1') {
                usuarioID = data.usuarioID;
                console.log("Usuario ID:", usuarioID);
    
                /*Aqui usamos la función cargarListas para cargar las listas del usuario
                y mostrar el contenido de la lista seleccionada dado que contiene el html
                necesario para mostrar las listas*/
                cargarListas(usuarioID);

            } else {
                alert('No estás logueado, redirigiendo al login');
                window.location.href = "Vista/iniciaSesion.html";
            }
        },
        error: function () {
            alert('Error al verificar la sesión');
            window.location.href = "Vista/iniciaSesion.html";
        }
    });
    /*Mostramos u ocultamos el formulario para crear una nueva lista cuando se
    hace click en el botón correspondiente.*/
    $('#crearLista').click(function () {
        $('#crearListaForm').toggle();
    });

    /*Cuando se pulsa el botón "Guardar Lista", pedimos el nombre de la lista.
    Enviamos esos datos al controlador para crearla sin ningún tipo fijo.*/
    $('#guardarLista').click(function () {
        const nombreLista = $('#nombreListaInput').val().trim();
        console.log('Nombre de la lista: ', nombreLista); //Añadimos un log para ver el valor de nombreLista
        console.log('usuarioID: ', usuarioID); //Añadimos un log para ver si el usuarioID está definido
        if (nombreLista && usuarioID) {
            $.ajax({
                url: '../Controlador/controladorLista.php',
                type: 'POST',
                data: {
                    accion: 'crearLista',
                    usuarioID: usuarioID,
                    nombreLista: nombreLista
                },
                success: function (respuesta) {
                    const r = JSON.parse(respuesta);
                    alert(r.mensaje); //Mostramos mensaje de confirmación
                    $('#crearListaForm').hide(); //Ocultamos el formulario
                    $('#nombreListaInput').val(''); //Limpiamos el input
                    cargarListas(usuarioID); // Recargamos las listas
                },
                error: function () {
                    alert("Error en la solicitud AJAX.");
                }
            });
        } else {
            alert('Por favor, introduce un nombre para la lista o verifica que estás logueado.');
        }
    });

    /*Al pulsar el botón de eliminar lista, se pide el nombre de la lista y se envía
    al controlador para que se elimine. Luego se actualiza el listado.*/
    $('#eliminarLista').click(function () {
        const $nombreLista = prompt('Introduce el nombre de la lista que deseas eliminar:');
        if ($nombreLista) {
            $.ajax({
                url: '../Controlador/controladorLista.php',
                type: 'POST',
                data: {
                    accion: 'eliminarLista',
                    NombreLista: $nombreLista
                },
                success: function (respuesta) {
                    const r = JSON.parse(respuesta);
                    alert(r.mensaje); //Mostramos el mensaje de eliminación
                    cargarListas(usuarioID); //Recargamos las listas
                }
            });
        }
    });

    /*Al pulsar el botón de agregar contenido, se obtienen los datos del formulario
    y se envían al controlador para añadirlo a la lista.*/
    $('#agregarContenido').click(function () {
        const idLista = $('#contenidoListaContainer').data('lista-id');
        const idContenido = $('#idContenido').val();
        const tipoContenido = $('#tipoContenido').val();

        if (idContenido && tipoContenido) {
            $.ajax({
                url: '../Controlador/controladorLista.php',
                type: 'POST',
                data: {
                    accion: 'agregarContenido',
                    idLista: idLista,
                    idContenido: idContenido,
                    tipoContenido: tipoContenido
                },
                success: function (respuesta) {
                    const r = JSON.parse(respuesta);
                    alert(r.mensaje);
                    mostrarContenidoLista(idLista, $('#nombreListaSeleccionada').text());
                }
            });
        } else {
            alert('Por favor, completa todos los campos.');
        }
    });

    /*Con esto generamos un evento que le da la función de eliminar al boton que se genera en nuestro html dinámico
    en la función de mostrarContenido. En este caso se carga otra vez el documento debido a que el html al que
    hace referencia no está generado dado que se genera, como hemos dicho, dinamicamente en la función de mostrar
    contenido.*/
    $(document).on('click', '.btn-eliminar-contenido', function(){
        const idLista = $('#contenidoListaContainer').data('lista-id');
        const idContenido = $(this).data('idcontenido');
    
        if (idLista && idContenido) {
            $.ajax({
                url: '../Controlador/controladorLista.php',
                type: 'POST',
                data: {
                    accion: 'eliminarContenido',
                    idLista: idLista,
                    idContenido: idContenido
                },
                success: function (respuesta) {
                    const r = JSON.parse(respuesta);
                    alert(r.mensaje);
                    mostrarContenidoLista(idLista, $('#nombreListaSeleccionada').text());
                },
                error: function () {
                    alert('Error al eliminar el contenido de la lista.');
                }
            });
        }
    });    

    //Cuando el usuario cambia el tipo de contenido, actualizamos el select con los contenidos disponibles
    $('#tipoContenido').change(function () {
        const tipo = $(this).val();

        if (tipo) {
            $.ajax({
                url: '../Controlador/controladorLista.php',
                type: 'POST',
                data: {
                    accion: 'obtenerContenidosDisponibles',
                    tipoContenido: tipo
                },
                success: function (respuesta) {
                    const contenidos = JSON.parse(respuesta);
                    const $select = $('#idContenido');
                    $select.empty();

                    if (contenidos.length > 0) {
                        $select.append('<option value="">Selecciona contenido</option>');
                        contenidos.forEach(c => {
                            $select.append(`<option value="${c.ID}">${c.Nombre}</option>`);
                        });
                    } else {
                        $select.append('<option value="">No hay contenidos disponibles</option>');
                    }
                },
                error: function () {
                    alert("Error al cargar los contenidos disponibles.");
                }
            });
        }
    });

    /*Para no tener que realizar una llamada al controladorLista de manera constante cuando actualizamos
    en el caso de 'obtenerLista' que es donde se hace uso
    del método getListasUsuarios que está en el modelo*/
    function cargarListas(usuarioID) {
        $.ajax({
            url: '../Controlador/controladorLista.php',
            method: 'POST',
            data: {
                accion: 'obtenerListas',
                usuarioID: usuarioID
            },
            success: function (respuesta) {
                const listas = JSON.parse(respuesta);
                let html = '';
    
                if (listas.length > 0) {
                    listas.forEach(lista => {
                        html += `
                            <div class="tarjeta-lista" data-id="${lista.ID}">
                                <h3>${lista.NombreLista}</h3>
                                <button class="ver-contenido" data-id="${lista.ID}">Ver Contenido</button>
                                <div class="contenido-lista" id="contenido-${lista.ID}" style="display: none;"></div>
                            </div>
                        `;
                    });
                } else {
                    html = '<p>No tienes listas aún.</p>';
                }
    
                $('#listas').html(html);
    
                //Activamos los botones "Ver Contenido"
                $('.ver-contenido').click(function () {
                    const idLista = $(this).data('id');
                    const nombreLista = $(this).siblings('h3').text();
                    mostrarContenidoLista(idLista, nombreLista);
                });
            },
            error: function () {
                alert('Error al obtener las listas');
            }
        });
    }
    
    //Función que se ejecuta al hacer clic en una lista y mostramos los contenidos después de editar la lista
    function mostrarContenidoLista(idLista, nombreLista) {
        $('#contenidoListaContainer').show(); //Mostramos el contenedor
        $('#nombreListaSeleccionada').text(nombreLista); //Mostramos el nombre

        //Guardamos el ID de la lista seleccionada (útil para otras acciones)
        $('#contenidoListaContainer').data('lista-id', idLista);

        $.ajax({
            url: '../Controlador/controladorLista.php',
            type: 'POST',
            data: {
                accion: 'obtenerContenidoLista',
                idLista: idLista
            },
            success: function (respuesta) {
                const contenidos = JSON.parse(respuesta);
                console.log(contenidos)
                const contenedor = $('#contenedorContenidoLista');
                contenedor.empty(); //Limpiamos contenido previo

                if (contenidos.length === 0) {
                    contenedor.append('<p>No hay contenido en esta lista.</p>');
                    return;
                }

                //Mostramos cada contenido con un botón para eliminarlo
                contenidos.forEach(contenido => {
                    contenedor.append(`
                        <div class="contenido-item">
                            <span>${contenido.Nombre} (${contenido.TipoContenido})</span>
                            <button class="btn-eliminar-contenido" data-idcontenido="${contenido.IDContenido}">Eliminar</button>
                        </div>
                    `);
                });
            }
        });
    }

});
