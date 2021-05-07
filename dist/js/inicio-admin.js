/*
* inicio-admin
* ------------------
* Aquí se listarán las distintas funciones de JavaScript
* que necesitaremos para el fichero:
* inicio-admin.php
*/

var datos_tabla, inicio, fin;
const filtrar = document.querySelector('#filtrarContenido');
const retroceder_tabla = document.querySelector('#prev');
const avanzar_tabla = document.querySelector('#next');

function representar_tabla(data, inicio = 0, fin = data.length) {
    let div = document.querySelector('.solicitudes');

    div.innerHTML = '';

    div.style.height = '100%';
    div.style.opacity = '100%';
    div.style.overflow = 'hidden';

    let tabla = document.createElement('table');
    tabla.className = "tabla";

    let thead = document.createElement('thead');
    let tr = document.createElement('tr');

    // CREACIÓN COLUMNAS TABLA //
    let th_num_solicitud = document.createElement('th');
    let th_tipo_solicitud = document.createElement('th');
    let th_nif = document.createElement('th');
    let th_fecha_solicitud = document.createElement('th');
    let th_fecha_solicitada = document.createElement('th');
    let th_respuesta = document.createElement('th');
    let th_anular = document.createElement('th');

    th_nif.id = "pc";
    th_fecha_solicitud.id = "pc";

    th_num_solicitud.appendChild(document.createTextNode('Solicitud'));
    th_tipo_solicitud.appendChild(document.createTextNode('Tipo de Solicitud'));
    th_nif.appendChild(document.createTextNode('NIF'));
    th_fecha_solicitud.appendChild(document.createTextNode('Solicitud Generada'));
    th_fecha_solicitada.appendChild(document.createTextNode('Fecha Solicitada'));
    th_respuesta.appendChild(document.createTextNode('Estado'));
    // th_anular.appendChild(document.createTextNode('Anular'));

    tr.appendChild(th_num_solicitud);
    tr.appendChild(th_tipo_solicitud);
    tr.appendChild(th_nif);
    tr.appendChild(th_fecha_solicitud);
    tr.appendChild(th_fecha_solicitada);
    tr.appendChild(th_respuesta);
    // tr.appendChild(th_anular);
    thead.appendChild(tr);

    // CREACIÓN FILAS TABLA //
    let tbody = document.createElement('tbody');
    tbody.id = "cuerpoTabla";

    for (let index = inicio; index < fin; index++) {
        let fila = data[index];
        let tr = document.createElement('tr');
        let th = document.createElement('th');

        th.id = 'Solicitud';
        th.appendChild(document.createTextNode(fila.Contador));

        let td1 = document.createElement('td');
        let td2 = document.createElement('td');
        let td3 = document.createElement('td');
        let td4 = document.createElement('td');
        let td5 = document.createElement('td');
        let td6 = document.createElement('td');

        // td6.innerHTML = `<input value='${fila.Contador}' type="checkbox" onchange="mostrar_aviso_anulacion()">`;

        td1.appendChild(document.createTextNode(fila.IdLicencia));
        td2.appendChild(document.createTextNode(fila.NIF));

        let fecha_solicitada = new Date(fila.FIni);
        let fecha_solicitud = new Date(fila.FSolicitud);

        td3.appendChild(document.createTextNode(moment(fecha_solicitud).format('DD/MM/YYYY (HH:MM)')));
        td4.appendChild(document.createTextNode(moment(fecha_solicitada).format('DD/MM/YYYY')));

        td5.appendChild(document.createTextNode(fila.Observaciones));

        tr.appendChild(th);
        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);
        tr.appendChild(td5);
        // tr.appendChild(td6);

        tbody.appendChild(tr);
    }

    tabla.appendChild(thead);
    tabla.appendChild(tbody);
    div.appendChild(tabla);
}

function generar_resumen(departamento) {
    let data_string = "departamento=" + departamento;

    $.ajax({
        type: "POST",
        data: data_string,
        url: '/files/getters/getResumenAdmin.php',
        success: function (data) {
            if (data.length > 0) {
                datos_tabla = JSON.parse(data);
                inicio = 0;
                fin = 10;

                representar_tabla(JSON.parse(data), inicio, fin);
            } else {
                var div = document.querySelector('.solicitudes');
                div.innerHTML = `<strong>No existen solicitudes.</strong>`;
                div.style.height = '100%';
                div.style.opacity = '100%';
                div.style.overflow = 'hidden';
            }
        },
        error: function () {
            alert("ERROR");
        }
    });
}

filtrar.addEventListener('click', function () {
    const ordenar = document.querySelector('#tipoOrden');
    const mostrar = document.querySelector('#numDias');
});

retroceder_tabla.addEventListener('click', (event) => {
    if (inicio - 10 >= 0) {
        representar_tabla(datos_tabla, inicio -= 10, fin -= 10);
    }
});

avanzar_tabla.addEventListener('click', (event) => {
    if (fin + 10 < datos_tabla.length) {
        representar_tabla(datos_tabla, inicio += 10, fin += 10);
    }
});