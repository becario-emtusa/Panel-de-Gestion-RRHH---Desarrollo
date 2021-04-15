/*
* inicio-admin
* ------------------
* Aquí se listarán las distintas funciones de JavaScript
* que necesitaremos para el fichero:
* inicio-admin.php
*/

function representar_tabla(data) {
    var div = document.querySelector('.solicitudes');

    div.innerHTML = '';

    div.style.height = '100%';
    div.style.opacity = '100%';
    div.style.overflow = 'hidden';

    if (div.childNodes.length <= 1) {
        var tabla = document.createElement('table');
        tabla.className = "tabla";

        var thead = document.createElement('thead');
        var tr = document.createElement('tr');

        // CREACIÓN COLUMNAS TABLA //
        var th_num_solicitud = document.createElement('th');
        var th_tipo_solicitud = document.createElement('th');
        var th_nif = document.createElement('th');
        var th_fecha_solicitud = document.createElement('th');
        var th_fecha_solicitada = document.createElement('th');
        var th_respuesta = document.createElement('th');
        var th_anular = document.createElement('th');

        th_nif.id = "pc";
        th_fecha_solicitud.id = "pc";

        th_num_solicitud.appendChild(document.createTextNode('Solicitud'));
        th_tipo_solicitud.appendChild(document.createTextNode('Tipo de Solicitud'));
        th_nif.appendChild(document.createTextNode('NIF'));
        th_fecha_solicitud.appendChild(document.createTextNode('Fecha de la Solicitud'));
        th_fecha_solicitada.appendChild(document.createTextNode('Fecha Solicitada'));
        th_respuesta.appendChild(document.createTextNode('Estado'));
        th_anular.appendChild(document.createTextNode('Anular'));

        tr.appendChild(th_num_solicitud);
        tr.appendChild(th_tipo_solicitud);
        tr.appendChild(th_nif);
        tr.appendChild(th_fecha_solicitud);
        tr.appendChild(th_fecha_solicitada);
        tr.appendChild(th_respuesta);
        tr.appendChild(th_anular);
        thead.appendChild(tr);

        // CREACIÓN FILAS TABLA //
        var tbody = document.createElement('tbody');
        tbody.id = "cuerpoTabla";

        for (var index = 0; index < data.length; index++) {
            var fila = data[index];
            var tr = document.createElement('tr');
            var th = document.createElement('th');

            th.id = 'Solicitud';
            th.appendChild(document.createTextNode(fila.Contador));

            var td1 = document.createElement('td');
            var td2 = document.createElement('td');
            var td3 = document.createElement('td');
            var td4 = document.createElement('td');
            var td5 = document.createElement('td');
            var td6 = document.createElement('td');

            td6.innerHTML = `<input value='${fila.Contador}' type="checkbox" onchange="mostrar_aviso_anulacion()">`;

            td1.id = 'pc';
            td1.appendChild(document.createTextNode(fila.IdLicencia));
            td2.appendChild(document.createTextNode(fila.NIF));
            td3.id = 'pc';

            var fecha_solicitada = new Date(fila.FIni);
            var fecha_solicitud = new Date(fila.FSolicitud);

            td3.appendChild(document.createTextNode(moment(fecha_solicitud).format('DD/MM/YYYY (HH:MM)')));
            td4.appendChild(document.createTextNode(moment(fecha_solicitada).format('DD/MM/YYYY')));

            td5.appendChild(document.createTextNode(fila.Observaciones));

            // switch (fila.Observaciones) {
            //     case null:
            //         var icon = document.createElement("i");
            //         icon.classList = 'far fa-question-circle';
            //         td5.appendChild(icon);
            //         break;
            //     case "Concesión automática":
            //         var icon = document.createElement("i");
            //         icon.classList = 'far fa-check-circle';
            //         td5.appendChild(icon);
            //         break;
            //     case "Solicitud Anulada":
            //     case "Anulación de Solicitud":
            //         var icon = document.createElement("i");
            //         icon.classList = 'far fa-times-circle';
            //         td5.appendChild(icon);
            //         break;
            //     default:
            //         break;
            // }

            tr.appendChild(th);
            tr.appendChild(td1);
            tr.appendChild(td2);
            tr.appendChild(td3);
            tr.appendChild(td4);
            tr.appendChild(td5);
            tr.appendChild(td6);

            tbody.appendChild(tr);
        }

        tabla.appendChild(thead);
        tabla.appendChild(tbody);
        div.appendChild(tabla);
    } else {
        div.style.height = '0';
        div.style.opacity = '0';
        div.style.overflow = 'hidden';
        div.innerHTML = "";
    }

}

function generar_resumen(departamento) {
    var data_string = "departamento=" + departamento;

    $.ajax({
        type: "POST",
        data: data_string,
        url: './fragmentos/getResumenAdmin.php',
        success: function (data) {
            if (data.length > 0) {
                representar_tabla(JSON.parse(data));
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