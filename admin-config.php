<!DOCTYPE html>
<html lang="es">

<?php
include 'files/parts/redirect.php';
include 'files/parts/cabecera.php';
?>

<head>
    <link rel="stylesheet" href="/dist/css/gestion.css">
    <title>Gestión de días - EMTUSA Huelva</title>
</head>

<body onload="get_num_dias();">
    <?php
    include 'files/parts/menu.php';
    ?>
    <!-- Header -->
    <header class="content-header">
        <div class="container-fluid">
            <h1>GESTIÓN</h1>
        </div>
    </header>

    <main>
        <div class="contenido">
            <div class="linea1" onchange="get_num_dias();">
                <div class="departamentos">
                    <label>Departamento</label>
                    <select name="selectDepartamentos" id="selectDepartamentos" class="selectDepart" value="-1">
                        <?php
                        /* Necesario incluir el fichero de conexion a la BBDD */
                        require_once("files/conn/conexionBBDD.php");

                        /* Creamos la conexion y lanzamos la consulta previamente diseñada */
                        $conexion = new conexionBBDD();
                        $statement = $conexion->getListaDepartamentosAdmin();

                        /* Generamos un option por cada valor que nos devuelva la consulta */
                        while ($row = $statement->fetch()) {
                            if ($row->Id == '3') {
                                echo '<option value=' . $row->Id . ' selected>' . $row->Denominacion . '</option>';
                            } else {
                                echo '<option value=' . $row->Id . '>' . $row->Denominacion . '</option>';
                            }
                        }

                        /* Al terminar cerramos la conexion */
                        $conexion->desconectar();
                        ?>
                    </select>
                </div>
                <div class="licencias" onchange="get_num_dias();">
                    <label>Licencia</label>
                    <select name="selectLicencias" id="selectLicencias" class="selectLicencias" value="-1">
                        <?php
                        /* Necesario incluir el fichero de conexion a la BBDD */
                        require_once("files/conn/conexionBBDD.php");

                        /* Creamos la conexion y lanzamos la consulta previamente diseñada */
                        $conexion = new conexionBBDD();
                        $statement = $conexion->getListaLicenciasAdmin();

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
            <div class="linea2">
                <div class="fecha">
                    <label>Fecha a modificar</label>
                    <input id="fecha-input" type="date" onchange="get_num_dias();">
                </div>
                <div class="dias">
                    <label>Modificar minimo de días</label>
                    <div class="stepper-dias">
                        <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="decremento"><i class="fas fa-minus-circle"></i></button>
                        <input class="dia-input" id="dia-input" type="number" max="???" min="0">
                        <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="incremento"><i class="fas fa-plus-circle"></i></button>
                    </div>
                </div>
            </div>
            <div class="linea3">
                <div class="concesion-automatica">
                    <label>¿Actualización inmediata?</label>
                    <input id="concesion-inmd-value" type="checkbox" onchange="mostrar_aviso()">
                </div>
            </div>
            <div class="aviso-concesion">
                <span><strong>Atención:</strong>Al confirmar esta acción<br>la orden se lanzará inmediatamente.
                </span>
            </div>
            <div class="mensaje">
                <span id="mensaje-span"></span>
            </div>
            <div class="linea4">
                <div class="boton-enviar">
                    <button class="enviar" onclick="modificar_dia()">Realizar Modificación</button>
                </div>
            </div>
        </div>
    </main>

    <div class="spacer"></div>

    <?php
    include 'files/parts/footer.php';
    ?>

    <script src="/dist/js/menu.js"></script>
    <script src="/dist/js/gestion.js"></script>
</body>


</html>