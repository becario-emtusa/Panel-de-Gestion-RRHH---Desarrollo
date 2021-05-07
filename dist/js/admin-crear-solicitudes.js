/*
* admin-crear-solicitudes
* ------------------
* Aquí se listarán las distintas funciones de JavaScript
* que necesitaremos para el fichero:
* admin-crear-solicitudes.php
*/

import { getHoraporFecha } from './funciones.js'

var Calendario = [];
var Horas_por_fecha = [];
var NIF_global = '';

const selectPeticion = document.querySelector('#selectPeticion');
const generar_solicitud = document.querySelector('#boton-datos');
const identificador = document.querySelector('#identificador');
const aviso = document.querySelector('.aviso_popup');
const boton_cerrar = document.querySelector('.cerrar');

identificador.addEventListener('change', (event) => {
    NIF_global = cargaDatos(identificador.value);
});

selectPeticion.addEventListener('change', (event) => {
    const opcion = selectPeticion.value;

    const divAAPP = document.querySelector('.AAPP');
    const divRM = document.querySelector('.RM');
    const divInfo = document.querySelector('.Info');
    const divMostrarCalAAPP = document.querySelector('.duracion-peticion-mostrar');
    const divCalAAPP = document.querySelector('.duracion-peticion');

    switch (opcion) {
        case "1":
            divInfo.style.visibility = 'hidden';
            divInfo.style.display = 'none';

            divAAPP.style.visibility = 'initial';
            divAAPP.style.display = 'initial';

            divRM.style.visibility = 'hidden';
            divRM.style.display = 'none';

            divMostrarCalAAPP.style.width = '95%';
            divCalAAPP.style.width = '600px';

            actualizarCalendario();
            break;
        case "7":
            divInfo.style.visibility = 'hidden';
            divInfo.style.display = 'none';

            divAAPP.style.visibility = 'hidden';
            divAAPP.style.display = 'none';

            divRM.style.visibility = 'initial';
            divRM.style.display = 'initial';

            divMostrarCalAAPP.style.width = '90%';
            divCalAAPP.style.width = '400px';

            actualizarCalendario();
            break;
        default:
            divInfo.style.visibility = 'initial';
            divInfo.style.display = 'initial';

            divRM.style.visibility = 'hidden';
            divRM.style.display = 'none';

            divAAPP.style.visibility = 'hidden';
            divAAPP.style.display = 'none';
            break;
    }
});

function actualizarCalendario() {
    let dni = NIF_global;
    const tipoLicencia = document.getElementById('selectPeticion').value;
    const dataString = `identificador=${dni}&tipoLicencia=${tipoLicencia}&admin=1`;

    if (dni != "" && selectPeticion.value > 0) {
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

                    for (let index = 0; index < json_obj.length; index++) {
                        Calendario.push([json_obj[index]["Fecha"], json_obj[index]["Activo"], json_obj[index]["Color"]]);

                        try {
                            Horas_por_fecha.push([json_obj[index]["Fecha"], json_obj[index]["Hora"]]);
                        } catch {
                            //
                        }
                    }

                    if (tipoLicencia === '1') {
                        var drp = $('#daterangepicker').data('daterangepicker');
                        drp.minDate = moment(json_obj[0]["Fecha"]);
                        drp.updateView();
                        drp.updateCalendars();
                    }

                    if (tipoLicencia === '7' || tipoLicencia === '8') {
                        var drp = $('#daterangepicker1').data('daterangepicker');
                        drp.startDate = moment(json_obj[0]["Fecha"]);
                        drp.minDate = moment(json_obj[0]["Fecha"]);
                        drp.updateView();
                        drp.updateCalendars();

                        var select = document.querySelector('#selectHoras');
                        select.innerHTML = '';
                        var valores = getHoraporFecha(json_obj[0]["Fecha"], Horas_por_fecha);

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
    } else {
        Calendario = [];
        return null;
    }
}

generar_solicitud.addEventListener('click', function recogerDatosFormulario() {
    let ident = NIF_global;

    /* Recogemos la Fecha de Inicio y la Fecha de Fin */
    let fechaIni = new Date($('#daterangepicker').data('daterangepicker').startDate);
    let fechaFin = new Date($('#daterangepicker').data('daterangepicker').endDate);

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
    const tipoLicencia = document.getElementById('selectPeticion').value;

    /* Preparamos los datos */
    const dataString = 'identificador=' + ident + "&fechaIni=" + fechaIni + "&fechaFin=" + fechaFin + "&tipoLicencia=" + tipoLicencia;

    $.ajax(
        {
            type: "POST",
            data: dataString,
            url: '/files/setters/insertarPeticionAdmin.php',
            success: function (data) {
                /* Recogemos las variables que usaremos para mostrar por pantalla */
                try {
                    const json_obj = JSON.parse(data);

                    let valor = json_obj[0]["id"];
                    let mensaje = json_obj[0]["mensaje"];

                    mostrar_aviso(mensaje);
                    //resultado_solicitud = valor;

                    const Speech = new SpeechSynthesisUtterance(mensaje);

                    Speech.volume = 1;
                    Speech.rate = 1;
                    Speech.pitch = 1;

                    window.speechSynthesis.speak(Speech);

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
});

function mostrar_aviso(mensaje) {
    /* Asignamos el texto a mostrar */
    document.getElementById('texto-aviso').innerHTML = `${mensaje}.`;

    /* Hacemos el aviso visible */
    aviso.style.display = "block";

    /* Si el usuario pulsa fuera del aviso, lo cierra */
    window.onclick = function (event) {
        if (event.target == aviso) {
            aviso.style.display = "none";
            window.location.replace('/admin/crear-solicitudes');
        }
    }
}

boton_cerrar.addEventListener('click', (event) => cerrar_aviso());

function cerrar_aviso() {
    aviso.style.display = 'none';
    window.location.replace('/admin/crear-solicitudes');
}

function getColorporFecha($pFecha, RM = false) {
    try {
        for (let elemento of Calendario) {
            const fechaCal = moment(elemento[0], $('#daterangepicker').data('daterangepicker').format);

            if (fechaCal.isSame($pFecha)) {
                let valores = new Object();
                let Activo = "1", Color = "V";

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

function cargaDatos(identificador) {
    if (identificador !== '') {
        const dataString = 'identificador=' + identificador;

        $.ajax(
            {
                type: "POST",
                data: dataString,
                url: '/files/getters/getDatos.php',
                success: function (data) {
                    try {
                        const json_obj = JSON.parse(data);

                        const nombre = document.querySelector('#inputNombre');
                        const categoria = document.querySelector('#inputCategoria');

                        nombre.value = json_obj["Nombre"] + ' ' + json_obj["Apellidos"];
                        categoria.value = json_obj["Categoria"].toLowerCase();
                        NIF_global = json_obj['nif'];

                        actualizarCalendario();
                    } catch (e) {
                        alert("Ha habido un error al procesar este usuario, revise la información.");
                    }
                },
                error: function () {
                    alert("¡Ha habido un fallo!");
                }
            }
        );
    }
}

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

var cal = $('#daterangepicker').daterangepicker({
    "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Guardar",
        "cancelLabel": "Cancelar",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
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
    "showISOWeekNumbers": true,
    "autoApply": true,
    "linkedCalendars": true,
    "minDate": moment(),
    "maxDate": moment().add(33, 'days'),
    "opens": "center",
    "parentEl": "#daterangepicker-container",
    "drops": "up",
    "isInvalidDate": function (date) {
        var valores = getColorporFecha(date);

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
        var valores = getColorporFecha(date);

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
    var valores = getHoraporFecha(picker.startDate, Horas_por_fecha);

    for (let hora of valores) {
        var option = document.createElement("option");
        option.value = hora;
        option.text = hora.slice(0, 5);
        select.add(option);
    }
});

cal.data('daterangepicker').hide = function () { };
cal.data('daterangepicker').show();

picker.data('daterangepicker').hide = function () { };
picker.data('daterangepicker').show();