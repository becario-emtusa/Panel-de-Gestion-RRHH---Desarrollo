<!DOCTYPE html>
<html lang="es">
<?php
include "./fragmentos/redirect.php";
include './fragmentos/cabecera.php';
?>

<head>
    <title>Solicitud de Licencias - EMTUSA Huelva</title>
</head>

<body onload="cargaDatos('<?php echo $_SESSION['login'] ?>');">
    <?php
    include './fragmentos/menu.php';
    ?>
    <header class="content-header">
        <div class="container-fluid">
            <h1>SOLICITUD DE LICENCIAS</h1>
        </div>
    </header>

    <main class="content d-flex justify-content-center">
        <div class="row" id="div-tarjetas">
            <div class="col-xs-4 col-sm-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Datos del peticionario</h3>
                    </div>
                    <form role="form">
                        <div class="card-body">
                            <div id="divDNI" class="row justify-content-center oculto" style="margin: auto;">
                                <div class="col-sm-12" style="display: inline-block; padding-left: initial;">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" id="inputNombre" placeholder="Nombre" readonly="readonly">
                                </div>
                            </div>
                            <div id="divDepartCat" class="row justify-content-center oculto" style="margin: auto;">
                                <div class="col-sm-6" style="display: inline-block; padding-left: initial; padding-top: 10px;">
                                    <label>Departamento</label>
                                    <input type="text" class="form-control" id="inputDepartamento" placeholder="Departamento" readonly="readonly" style="text-transform: capitalize;">
                                </div>
                                <div class="col-sm-6" style="display: inline-block; padding-left: initial; padding-top: 10px;">
                                    <label>Categoría</label>
                                    <input type="text" class="form-control" id="inputCategoria" placeholder="Categoría" readonly="readonly" style="text-transform: capitalize;">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-xs-4 col-sm-12">
                <div id="Contenedor_Motivo" class="card card-primary tarjetaOculto">
                    <div class="card-header">
                        <h3 class="card-title">Motivo de la petición</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Seleccione el motivo de la petición</label>
                            <select id="selectMotivoPeticion" onchange="mostrarTextoUnidadTiempo();" class="form-control">
                                <option value="0">Seleccione motivo</option>
                                <?php
                                /* Necesario incluir el fichero de conexion a la BBDD */
                                require_once("./fragmentos/conexionBBDD.php");

                                /* Creamos la conexion y lanzamos la consulta previamente diseñada */
                                $conexion = new conexionBBDD();
                                $statement = $conexion->getMotivosPeticion();

                                /* Generamos un option por cada valor que nos devuelva la consulta */
                                while ($row = $statement->fetch()) {
                                    echo '<option value=' . $row->Id . '>' . $row->Denominacion . '</option>';
                                }

                                /* Al terminar cerramos la conexion */
                                $conexion->desconectar();
                                ?>
                            </select>
                        </div>
                        <div id="divMotivoLicencia">
                            <input type="text" class="form-control" id="inputMotivoLicencia" placeholder="Especifique motivo">
                        </div>
                        <div id="divMostrarTablaDiasPendientes" class="form-group" style="padding-top: 10px;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-4 col-sm-12">
                <div id="Contenedor_Duracion" class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Duración de la petición</h3>
                    </div>
                    <form role="form">
                        <div class="card-body row-sm-12">
                            <div id="divNumerico" class="container text-center">
                                <div class="row justify-content-center" id="Horas" style="margin: auto;">
                                    <div class="col-sm-3" style="display: inline-block; padding-left: initial; padding-top: 20px;">
                                        <label style="font-size: 15px;">Hora de inicio:</label>
                                        <input type="time" class="form-control" id="inputInicio" value="00:00" style="text-align: center; width: 100%;">
                                    </div>
                                    <br>
                                    <div class="col-sm-3" style="display: inline-block; padding-left: initial; padding-top: 20px;">
                                        <label>Hora de fin:</label>
                                        <input type="time" class="form-control" id="inputFin" value="23:59" style="text-align: center; width: 100%;">
                                    </div>
                                    <div class="col-sm-4" style="display: inline-block; padding-left: initial; padding-top: 20px;">
                                        <label>Fecha:</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                            <input type="text" class="form-control" id="inputFecha" style="text-align: center;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="divCalendario">
                                <div class="col-sm-12" style="display: inline-block; padding-left: initial;">
                                    <label>Seleccione intervalo de fecha:</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="margin-right: 4px;">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                        <input type="text" class="form-control float-right" id="inputFecha2" style="text-align: center; font-size: 14px; cursor: pointer;" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12" style="display: inline-block; padding-left: initial;">
                                    <label>Días seleccionados:</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="margin-right: 4px;">
                                            <i class="far fa-clock"></i>
                                        </span>
                                        <input type="text" class="form-control float-right" id="contadorDias" style="text-align: center; font-size: 16px; cursor: inherit;" readonly>
                                    </div>
                                </div>
                            </div>
                            <div id="divCalendario2">
                                <div id="contentCalendario2">
                                    <div id="etiquetas">
                                        <label>Seleccione una fecha:</label>
                                        <label>Horas:</label>
                                    </div>
                                    <div>
                                        <input type="hidden" class="form-control float-right" id="daterangepicker1" style="text-align: center; font-size: 14px; cursor: pointer;" readonly>
                                        <div id="daterangepicker1-container" class="embedded-daterangepicker"></div>
                                    </div>
                                    <div id="div-select-horas">
                                        <select name="selectHoras" id="selectHoras">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="divBotonEnviar" class="row-sm-12 text-center">
                <button type="button" class="btn botonEnviar" id="buttonFin" onclick="recogerDatosFormulario()">Enviar petición <i class="far fa-check-circle"></i></button>
            </div>
            <div class="aviso_popup">
                <div class="contenido-popup">
                    <p><strong id="texto-aviso"></strong></p>
                    <div class="boton-cerrar-aviso">
                        <button class="cerrar" onclick="cerrar_aviso()">Cerrar aviso</button>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </main>

    <?php
    include './fragmentos/footer.php';
    ?>

    <script src="../../dist/js/realizar-solicitudes.js"></script>
    <script src="../../dist/js/menu.js"></script>
</body>

</html>