<!DOCTYPE html>
<html lang="es">

<?php
include "files/parts/redirect.php";
include 'files/parts/cabecera.php';
?>

<link rel="stylesheet" href="/dist/css/crear-solicitudes-admin.css">

<script>
    $(function() {
        $('#inputFecha').daterangepicker({
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
            "minYear": 2021,
            "maxYear": 2050,
            "showISOWeekNumbers": true,
            "autoApply": true,
            "linkedCalendars": true,
            "showCustomRangeLabel": false,
            "minDate": null,
            "maxDate": moment().add(33, 'days'),
            "opens": "center",
            "drops": "up",
            "isInvalidDate": function(date) {
                var valores = getColorporFecha(date);

                if (valores != undefined) {
                    switch (valores["Activo"] + "|" + valores["Color"]) {
                        case "0|null":
                            return true;
                            break;
                        default:
                            return false;
                            break;
                    }
                } else {
                    return true;
                }
            },
            "isCustomDate": function(date) {
                var valores = getColorporFecha(date);

                if (valores != undefined) {
                    switch (valores["Activo"] + "|" + valores["Color"]) {
                        case "0|R":
                            return "disabled off";
                            break;
                        case "1|V":
                            return "diaLibre";
                            break;
                        case "1|R":
                            return "diaOcupado";
                            break;
                        case '0|Z':
                            return "diaPedido";
                            break;
                        default:
                            return "";
                            break;
                    }
                }
            }
        }, function(start, end, label) {

            date1 = new Date(start);
            date2 = new Date(end);

            date1.setHours(date1.getHours() + 1);

            if (moment(date1).isDST()) {
                date1.setHours(date1.getHours() + 1);
                date2.setHours(date2.getHours() + 1);
            }

            console.log(date1.toISOString(), date2.toISOString());
            //console.log(moment(date1).format('YYYYMMDD'), moment(date2).format('YYYYMMDD'));
            //console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        }).on('apply.daterangepicker', function(ev, picker) {
            var start = moment(picker.startDate.format('YYYY-MM-DD'));
            var end = moment(picker.endDate.format('YYYY-MM-DD'));
            var diff = end.diff(start, 'days'); // returns correct number
            //document.getElementById('contadorDias').value = diff + 1;
        }).on('showCalendar.daterangepicker', function(ev, picker) {
            /* IMPLEMENTACIÓN DE LEYENDA DE LOS DÍAS */
        });
    });
</script>

<head>
    <title>Creación de licencias - EMTUSA Huelva</title>
</head>

<body>
    <?php
    include 'files/parts/menu.php';
    ?>

    <header>
        <div class="titulo">
            <h2>CREACIÓN DE SOLICITUDES</h2>
        </div>
    </header>

    <main class="contenido">
        <div class="simple-">
            <div class="content1">
                <div class="datos-personal">
                    <div class="tarjeta-titulo">
                        <label>Datos Personal</label>
                    </div>
                    <div class="datos-personal-mostrar">
                        <div id="datos-usuario">
                            <div class="informacion_usuario" id="div_nif">
                                <label>NIF, NºConductor, NºEmpleado...</label>
                                <input type="text" id="identificador" placeholder="Introduzca el identificador...">
                            </div>
                            <div class="informacion_usuario" id="div_nombre">
                                <label>Nombre</label>
                                <input type="text" id="inputNombre" placeholder="..." readonly>
                            </div>
                            <div class="informacion_usuario" id="div_categoria">
                                <label>Categoria</label>
                                <input type="text" placeholder="..." id="inputCategoria" readonly>
                            </div>
                            <div class="informacion_usuario" id="div_motivo">
                                <label>Motivo</label>
                                <div>
                                    <select id="selectPeticion">
                                        <option value="0">Seleccione motivo</option>
                                        <?php
                                        /* Necesario incluir el fichero de conexion a la BBDD */
                                        require_once("files/conn/conexionBBDD.php");

                                        /* Creamos la conexion y lanzamos la consulta previamente diseñada */
                                        $conexion = new conexionBBDD();
                                        $statement = $conexion->getMotivosPeticion(1);

                                        /* Generamos un option por cada valor que nos devuelva la consulta */
                                        while ($row = $statement->fetch()) {
                                            echo '<option value=' . $row->Id . '>' . $row->Denominacion . '</option>';
                                        }

                                        /* Al terminar cerramos la conexion */
                                        $conexion->desconectar();
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content2">
                <div class="duracion-peticion">
                    <div class="tarjeta-titulo">
                        <label>Calendario</label>
                    </div>
                    <div class="duraction-peticion-mostrar Info">
                        <p>Inserte el DNI y el motivo para generar el calendario.</p>
                    </div>
                    <div class="duracion-peticion-mostrar AAPP">
                        <input type="hidden" id="daterangepicker" readonly>
                        <div id="daterangepicker-container" class="embedded-daterangepicker"></div>
                        <!-- <input type="text" id="inputFecha" readonly> -->
                    </div>
                    <div class="duracion-peticion-mostrar RM">
                        <div id="contenidoCalendarioRm">
                            <div class="etiquetas">
                                <label>Seleccione una fecha:</label>
                                <label>Fecha:</label>
                            </div>
                            <input type="hidden" id="daterangepicker1" readonly>
                            <div id="daterangepicker1-container" class="embedded-daterangepicker"></div>
                            <div id="div-select-horas">
                                <select name="selectHoras" id="selectHoras">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="enviar-datos">
            <button id="boton-datos">Generar Solicitud</button>
        </div>
        <div class="aviso_popup">
            <div class="contenido-popup">
                <p><strong id="texto-aviso"></strong></p>
                <div class="boton-cerrar-aviso">
                    <button class="cerrar">Cerrar aviso</button>
                </div>
            </div>
        </div>
    </main>

    <?php
    include 'files/parts/footer.php';
    ?>

    <script src="/dist/js/admin-crear-solicitudes.js" type="module"></script>

</body>


</html>