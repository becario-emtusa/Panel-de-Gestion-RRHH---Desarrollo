const contenido_citas = document.querySelector('.contenido-citas');
const fecha = document.querySelector('#fecha-input');
var citas = [];

window.onload = () => {
    cargar_citas();
}

cargar_citas = () => {
    let data_string = `fecha=${fecha.value}`;

    $.ajax(
        {
            type: "POST",
            data: data_string,
            url: '/files/getters/getDatosCita.php',
            success: function (data) {
                let contenido = JSON.parse(data);
                citas = contenido;

                if (contenido[0]["Id"] > 0) {
                    representar_tabla(JSON.parse(data));
                } else {
                    let span = document.createElement('strong');
                    span.appendChild(document.createTextNode('No existen citas para esa fecha.'));
                    span.style.padding = '0.25rem 1rem';
                    contenido_citas.innerHTML = '';
                    contenido_citas.appendChild(span);
                }

            },
            error: () => {
                alert(`Ha ocurrido un error al cargar la información de la fecha ${fecha.value}`);
            }
        }
    );
}

fecha.addEventListener('change', (event) => {
    cargar_citas();
});

representar_tabla = (data) => {
    contenido_citas.innerHTML = '';

    contenido_citas.style.height = '100%';
    contenido_citas.style.opacity = '100%';
    contenido_citas.style.overflow = 'hidden';

    let tabla = document.createElement('table');
    tabla.className = "tabla";

    let thead = document.createElement('thead');
    let tr = document.createElement('tr');

    // CREACIÓN COLUMNAS TABLA //
    let th_id_cita = document.createElement('th');
    let th_tipo_solicitud = document.createElement('th');
    let th_fecha = document.createElement('th');
    let th_id_solicitud = document.createElement('th');
    let th_aptitud = document.createElement('th');
    let th_mod = document.createElement('th');

    th_id_cita.appendChild(document.createTextNode('Número de Cita'));
    th_tipo_solicitud.appendChild(document.createTextNode('Tipo'));
    th_fecha.appendChild(document.createTextNode('Fecha'));
    th_id_solicitud.appendChild(document.createTextNode('Número de Solicitud'));
    th_aptitud.appendChild(document.createTextNode('Aptitud'));
    th_mod.appendChild(document.createTextNode('Modificar'));

    tr.appendChild(th_id_cita);
    tr.appendChild(th_tipo_solicitud);
    tr.appendChild(th_fecha);
    tr.appendChild(th_id_solicitud);
    tr.appendChild(th_aptitud);
    tr.appendChild(th_mod);
    thead.appendChild(tr);

    // CREACIÓN FILAS TABLA //
    let tbody = document.createElement('tbody');
    tbody.id = "cuerpoTabla";

    for (let index = 0; index < data.length; index++) {
        let fila = data[index];
        let tr = document.createElement('tr');
        let th = document.createElement('th');

        tr.id = fila.Id;
        th.appendChild(document.createTextNode(fila.Id));

        let td1 = document.createElement('td');
        let td2 = document.createElement('td');
        let td3 = document.createElement('td');
        let td4 = document.createElement('td');
        let td5 = document.createElement('td');

        td1.appendChild(document.createTextNode(fila.TipoLicencia));
        let fecha_solicitud = new Date(fila.Fecha);
        td2.appendChild(document.createTextNode(moment(fecha_solicitud).format('DD/MM/YYYY (HH:mm)')));

        switch (fila.IdSolicitud) {
            case null:
                td3.appendChild(document.createTextNode('Sin Asignar'));
                break;
            default:
                td3.appendChild(document.createTextNode(fila.IdSolicitud));
        }
        switch (fila.Aptitud) {
            case null:
                td4.appendChild(document.createTextNode('Sin Asignar'));
                break;
            default:
                td4.appendChild(document.createTextNode(fila.Aptitud));
        }

        td5.innerHTML = `<input value='${fila.Id}' id='${fila.Id}' type="checkbox">`;

        tr.appendChild(th);
        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);
        tr.appendChild(td5);

        tbody.appendChild(tr);
    }

    tabla.appendChild(thead);
    tabla.appendChild(tbody);
    contenido_citas.appendChild(tabla);
}

document.addEventListener('change', (event) => {
    event.composedPath().forEach(elemento => {
        if (elemento.type === 'checkbox' && (elemento.value > 0)) {
            const num_cita = document.querySelector('#cita-number-mod');
            const hora_cita = document.querySelector('#hora_cita');
            num_cita.value = event.target.value;

            citas.forEach(elemento => {
                if (elemento["Id"] === event.target.value) {
                    let hora = moment(elemento['Fecha']).format('HH:mm');
                    hora_cita.value = hora;
                }
            });

        }
    });
});

const boton_generar_cita = document.querySelector('#insertar-cita');

boton_generar_cita.addEventListener('click', (event) => {
    const fecha_leida = document.querySelector('#fecha-input').value;
    const fecha = moment(fecha_leida).format('YYYY-DD-MM');
    const hora = document.querySelector('#hora-cita').value;
    const num_citas = document.querySelector('#dia-input').value;

    let data_string = `tipoLicencia=7&fecha=${fecha + ' ' + hora}&numeroCitas=${num_citas}`;

    $.ajax(
        {
            type: "POST",
            data: data_string,
            url: '/files/setters/insertarCita.php',
            success: function (data) {
                cargar_citas();
            },
            error: () => {
                alert(`Ha ocurrido un error al cargar la información de la fecha ${fecha.value}`);
            }
        }
    );

});