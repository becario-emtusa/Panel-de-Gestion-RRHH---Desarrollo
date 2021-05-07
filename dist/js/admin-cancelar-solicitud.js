const num_solicitud = document.querySelector('#identificador');
const cancelar_solicitud = document.querySelector('#boton-datos');

num_solicitud.addEventListener('change', (event) => {
    const nombre = document.querySelector('#inputNombre');
    const fecha = document.querySelector('#inputFechaSolicitud');
    const estado = document.querySelector('#inputEstado');

    const data_string = `num_solicitud=${num_solicitud.value}`;

    $.ajax({
        type: "POST",
        data: data_string,
        url: '/files/getters/getSolicitud.php',
        success: function (data) {
            if (data.length > 0) {
                datos_solicitud = JSON.parse(data)[0];
                nombre.value = datos_solicitud['Nombre'];
                fecha.value = datos_solicitud['Fecha'];

                if (datos_solicitud['Estado'] == null) {
                    estado.value = "Pendiente";
                } else {
                    estado.value = datos_solicitud['Estado'];
                }
            }
        },
        error: function () {
            alert("ERROR");
        }
    });
});


cancelar_solicitud.addEventListener('click', (event) => {
    if (num_solicitud.value) {
        const data_string = `num_solicitud=${num_solicitud.value}&admin=1`;

        $.ajax({
            type: "POST",
            data: data_string,
            url: '/files/setters/setAnulacion.php',
            success: function (data) {
                resultado = JSON.parse(data)[0];
                mostrar_aviso(resultado['Mensaje']);
            },
            error: function () {
                alert("ERROR");
            }
        })
    }
});

const aviso = document.querySelector('.aviso_popup');

mostrar_aviso = (mensaje) => {
    document.getElementById('texto-aviso').innerHTML = `${mensaje}.`;
    aviso.style.display = "block";

    /* Si el usuario pulsa fuera del aviso, lo cierra */
    window.onclick = function (event) {
        if (event.target == aviso) {
            aviso.style.display = "none";
            window.location.replace('/admin/cancelar-solicitud');
        }
    }
}

cerrar_aviso = () => {
    aviso.style.display = 'none';
    window.location.replace('/admin/cancelar-solicitud');
}

