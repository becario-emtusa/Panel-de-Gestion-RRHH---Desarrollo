/*
 * realizar-solicitudes.js
 * ------------------
 * Aquí se listarán las distintas funciones de JavaScript
 * que se necesitarán para el correcto funcionamiento.
 */

var Calendario = [];
var Horas_por_fecha = [];
var NIF_global;

function getColorporFecha($pFecha, RM = false) {
    try {
        for (let elemento of Calendario) {
            var fechaCal = moment(elemento[0], $('#inputFecha2').data('daterangepicker').format);

            if (fechaCal.isSame($pFecha)) {
                var valores = new Object();

                var Activo = "1", Color = "V";

                if (!RM) {
                    Activo = elemento[1];
                    Color = elemento[2];

                    valores["Activo"] = Activo;
                    valores["Color"] = Color;

                } else {
                    valores["Activo"] = "1";
                    valores["Color"] = "V";
                }

                return {
                    "Activo": Activo,
                    "Color": Color
                };
            }
        }
    } catch (e) {
        console.log(e);
    }
}

function getHoraporFecha($pFecha) {
    try {
        var valores = [];

        for (let elemento of Horas_por_fecha) {
            var fechaCal = moment(elemento[0], $('#daterangepicker1').data('daterangepicker').format);

            if (fechaCal.isSame($pFecha)) {
                valores.push(elemento[1]);
            }
        }

        for (var index = valores.length - 1; index >= 1; index--) {
            if (valores[index].slice(0, 5) === valores[index - 1].slice(0, 5)) {
                valores.pop(valores[index]);
            }
        }

        return valores;
    } catch (e) {
        console.log(e);
    }
}

function mostrarTextoUnidadTiempo() {
    const motivo_peticion = document.querySelector('#selectMotivoPeticion');
    const contenedor_motivo = document.querySelector('#Contenedor_Motivo');
    const contenedor_duracion = document.querySelector('#Contenedor_Duracion');
    const input_horas = document.querySelector('#divNumerico');
    const div_boton_enviar = document.querySelector('#divBotonEnviar');
    const calendario_completo = document.querySelector('#divCalendario');
    const calendario_basico = document.querySelector('#divCalendario2');

    input_horas.style.height = '0';
    input_horas.style.overflow = 'hidden';

    switch (motivo_peticion.value) {
        case '1':
            /* Asuntos propios */
            contenedor_motivo.style.maxHeight = '400px';
            contenedor_duracion.style.height = '225px';

            calendario_completo.style.height = 'initial';
            calendario_basico.style.height = '0';

            div_boton_enviar.style.height = 'initial';
            div_boton_enviar.style.overflow = 'initial';
            div_boton_enviar.classList.add('button-mobile');
            consultaDias();
            actualizarCalendario();
            break;
        case '7':
            /* Reconocimiento médico */
            contenedor_motivo.style.maxHeight = '160px';
            contenedor_duracion.style.height = '340px';
            contenedor_duracion.style.maxHeight = '500px';

            calendario_basico.style.height = 'initial';
            calendario_completo.style.height = '0';

            div_boton_enviar.style.height = 'initial';
            div_boton_enviar.style.overflow = 'initial';
            div_boton_enviar.classList.add('button-mobile');
            actualizarCalendario();
            break;
        case '8':
            /* CAP */
            contenedor_motivo.style.maxHeight = '160px';
            contenedor_duracion.style.height = '225px';

            calendario_basico.style.height = '0';
            calendario_completo.style.height = '0';

            div_boton_enviar.style.height = 'initial';
            div_boton_enviar.style.overflow = 'initial';
            div_boton_enviar.classList.add('button-mobile');
            actualizarCalendario();
            break;
        case '0':
            contenedor_motivo.style.maxHeight = '160px';
            contenedor_motivo.style.overflow = 'hidden';

            calendario_basico.style.height = '0';
            calendario_completo.style.height = '0';

            contenedor_duracion.style.height = '0';
            contenedor_duracion.style.overflow = 'hidden';

            div_boton_enviar.style.height = '0';
            div_boton_enviar.style.overflow = 'hidden';
            div_boton_enviar.classList.remove('button-mobile');
            break;
    }
}

function mostrarTextoMotivoPeticion() {
    switch (document.getElementById('selectMotivoPeticion').value) {
        case "1":
            document.getElementById('divMotivoLicencia').style.visibility = 'none';
            document.getElementById('inputMotivoLicencia').style.visibility = 'hidden';
            document.getElementById('Contenedor_Motivo').style.minHeight = '160px';
            break;
        default:
            document.getElementById('divMotivoLicencia').style.visibility = 'none';
            document.getElementById('inputMotivoLicencia').style.visibility = 'hidden';
            document.getElementById('Contenedor_Motivo').style.minHeight = '160px';
            break;
    }
}

function cargaDatos(NIF) {
    NIF_global = NIF;
    var dataString = 'identificador=' + NIF;

    $.ajax(
        {
            type: "POST",
            data: dataString,
            url: '/files/getters/getDatos.php',
            success: function (data) {
                var json_obj = JSON.parse(data);

                document.getElementById("inputNombre").value = json_obj["Nombre"] + ' ' + json_obj["Apellidos"];
                document.getElementById("inputDepartamento").value = json_obj["Departamento"].toLowerCase();
                document.getElementById("inputCategoria").value = json_obj["Categoria"].toLowerCase();

                document.getElementById('Contenedor_Motivo').classList.remove('tarjetaOculto');
                document.getElementById('divDNI').classList.remove('oculto');
                document.getElementById('divDepartCat').classList.remove('oculto');

            },
            error: function () {
                alert("¡Ha habido un fallo!");
            }
        }
    );
}

function creaTabla(data) {
    var div = document.getElementById("divMostrarTablaDiasPendientes");
    div.innerHTML = '';

    var tabla = document.createElement('table');
    tabla.className = "table table-striped";

    var thead = document.createElement('thead');
    var tr = document.createElement('tr');

    // CREACIÓN COLUMNAS TABLA //
    var thAnio = document.createElement('th');
    var thTotal = document.createElement('th');

    thAnio.scope = "col";
    thTotal.scope = "col";

    thAnio.appendChild(document.createTextNode('Año'));
    thTotal.appendChild(document.createTextNode('Días Disponibles'));

    tr.appendChild(thAnio);
    tr.appendChild(thTotal);
    thead.appendChild(tr);

    // CREACIÓN FILAS TABLA //
    var tbody = document.createElement('tbody');
    tbody.id = "cuerpoTabla";

    for (var index = 0; index < data.length; index++) {
        var fila = data[index];
        var tr = document.createElement('tr');

        var th = document.createElement('th');
        th.scope = "row";

        th.appendChild(document.createTextNode(fila.Año));

        var td = document.createElement('td');
        td.appendChild(document.createTextNode(fila.Total));

        tr.appendChild(th);
        tr.appendChild(td);

        tbody.appendChild(tr);
    }

    tabla.appendChild(thead);
    tabla.appendChild(tbody);
    div.appendChild(tabla);
}

function consultaDias() {
    var tipoLicencia = document.getElementById('selectMotivoPeticion').value;
    var dataString = 'identificador=' + NIF_global + "&tipoLicencia=" + tipoLicencia;
    actualizarCalendario();

    $.ajax(
        {
            type: "POST",
            data: dataString,
            url: '/files/getters/getDias.php',
            success: function (data) {
                creaTabla(JSON.parse(data));
            },
            error: function () {
                alert("¡Ha habido un fallo!");
            }
        }
    );
}

function actualizarCalendario() {
    var tipoLicencia = document.getElementById('selectMotivoPeticion').value;
    var dataString = 'identificador=' + NIF_global + "&tipoLicencia=" + tipoLicencia;

    $.ajax(
        {
            type: "POST",
            data: dataString,
            url: '/files/getters/getCalendario.php',
            success: function (data) {
                var json_obj = JSON.parse(data);

                /* Vaciamos el calendario actual para volver a iniciarlo. */
                Calendario = [];
                Horas_por_fecha = [];

                for (index = 0; index < json_obj.length; index++) {
                    Calendario.push([json_obj[index]["Fecha"], json_obj[index]["Activo"], json_obj[index]["Color"]]);

                    try {
                        Horas_por_fecha.push([json_obj[index]["Fecha"], json_obj[index]["Hora"]]);
                    } catch {
                        //
                    }
                }

                if (tipoLicencia === '7' || tipoLicencia === '8') {
                    var drp = $('#daterangepicker1').data('daterangepicker');
                    drp.startDate = moment(json_obj[0]["Fecha"]);
                    drp.minDate = moment(json_obj[0]["Fecha"]);
                    drp.updateView();
                    drp.updateCalendars();

                    var select = document.querySelector('#selectHoras');
                    select.innerHTML = '';
                    var valores = getHoraporFecha(json_obj[0]["Fecha"]);

                    for (let hora of valores) {
                        var option = document.createElement("option");
                        option.value = hora;
                        option.text = hora.slice(0, 5);
                        select.add(option);
                    }
                }
            },
            error: function () {
                alert("Ha ocurrido un error al cargar el calendario.");
                return null;
            }
        }
    );
}

const aviso = document.querySelector('.aviso_popup');

function mostrar_aviso(mensaje) {
    /* Asignamos el texto a mostrar */
    document.getElementById('texto-aviso').innerHTML = `${mensaje}.`;

    /* Hacemos el aviso visible */
    aviso.style.display = "block";

    /* Si el usuario pulsa fuera del aviso, lo cierra */
    window.onclick = function (event) {
        if (event.target == aviso) {
            aviso.style.display = "none";
            if (resultado_solicitud == '0') {
                window.location.replace('/consultar-solicitudes');
            }
        }
    }
}

var resultado_solicitud = '-1';

cerrar_aviso = () => {
    aviso.style.display = 'none';

    if (resultado_solicitud == '0') {
        window.location.replace('/consultar-solicitudes');
    }
}

recogerDatosFormulario = () => {
    /* Recogemos la Fecha de Inicio y la Fecha de Fin */
    var fechaIni = new Date($('#inputFecha2').data('daterangepicker').startDate);
    var fechaFin = new Date($('#inputFecha2').data('daterangepicker').endDate);

    /* Ajuste de hora */
    fechaIni.setHours(fechaIni.getHours() + 1);

    /* Ajuste de Fechas si es horario de verano */
    if (moment(fechaIni).isDST()) {
        fechaIni.setHours(fechaIni.getHours() + 1);
    }

    if (moment(fechaFin).isDST()) {
        fechaFin.setHours(fechaFin.getHours() + 1);
    }

    /* Conversion a SQL Server Date */
    fechaIni = fechaIni.toISOString().slice(0, 19);
    fechaFin = fechaFin.toISOString().slice(0, 19);

    /* Recogemos el tipo de Licenia */
    var tipoLicencia = document.getElementById('selectMotivoPeticion').value;

    /* Preparamos los datos */
    var dataString = 'identificador=' + NIF_global + "&fechaIni=" + fechaIni + "&fechaFin=" + fechaFin + "&tipoLicencia=" + tipoLicencia;

    $.ajax(
        {
            type: "POST",
            data: dataString,
            url: '/files/setters/insertarPeticion.php',
            success: function (data) {
                /* Recogemos las variables que usaremos para mostrar por pantalla */
                try {

                    var json_obj = JSON.parse(data);
                    var valor = json_obj[0]["id"];
                    var mensaje = json_obj[0]["mensaje"];

                    mostrar_aviso(mensaje);

                    const Speech = new SpeechSynthesisUtterance(mensaje);

                    Speech.volume = 1;
                    Speech.rate = 1;
                    Speech.pitch = 1;

                    window.speechSynthesis.speak(Speech);

                    resultado_solicitud = valor;

                } catch (e) {
                    alert(data);
                    console.log("Ha ocurrido un error: " + e);
                }

                /* Actualizamos el calendario después de hacer la nueva inserción. */
                actualizarCalendario();
            },
            error: function () {
                alert("Ha ocurrido un error la realizar la petición, vuelva a intentarlo más tarde.");
            }
        }
    )
}

/* PRUEBAS */
// init daterangepicker 
var picker = $('#daterangepicker1').daterangepicker({
    "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "weekLabel": "Sem",
        "firstDay": 1,
        "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ]
    },
    "minDate": moment(),
    "maxDate": moment().add(33, 'days'),
    "singleDatePicker": true,
    "autoApply": true,
    "maxSpan": {
        "days": 7
    },
    "alwaysShowCalendars": true,
    "opens": "center",
    "drops": "auto",
    "parentEl": "#daterangepicker1-container",
    "isInvalidDate": function (date) {
        var valores = getColorporFecha(date, true);

        if (valores != undefined) {
            switch (valores["Activo"] + "|" + valores["Color"]) {
                case "0|null":
                    return true;
                default:
                    return false;
            }
        } else {
            return true;
        }
    },
    "isCustomDate": function (date) {
        var valores = getColorporFecha(date, true);

        if (valores != undefined) {
            switch (valores["Activo"] + "|" + valores["Color"]) {
                case "0|R":
                    return "disabled off";
                case "1|V":
                    return "diaLibre";
                case "1|R":
                    return "diaOcupado";
                case '0|Z':
                    return "diaPedido";
                default:
                    return "";
            }
        }
    }
});

// range update listener
picker.on('apply.daterangepicker', (ev, picker) => {
    var select = document.querySelector('#selectHoras');
    select.innerHTML = '';
    var valores = getHoraporFecha(picker.startDate);

    for (let hora of valores) {
        var option = document.createElement("option");
        option.value = hora;
        option.text = hora.slice(0, 5);
        select.add(option);
    }
});

// prevent hide after range selection
picker.data('daterangepicker').hide = function () { };

// show picker on load
picker.data('daterangepicker').show();