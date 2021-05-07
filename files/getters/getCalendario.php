<?php
require_once("../conn/conexionBBDD.php");
session_start();

/* Obtenemos el campo que hemos pasado desde JQuery */
$dni = $_POST['identificador'];
$tipoLicencia = $_POST['tipoLicencia'];

/* Crecamos la conexion y lanzamos la consulta previamente diseñada */
$conexion = new conexionBBDD();

if ($tipoLicencia != 7) {
    if (isset($_POST['admin'])) {
        $statement = $conexion->getCalendarioUsuario($dni, $tipoLicencia, 1);
    } else {
        $statement = $conexion->getCalendarioUsuario($dni, $tipoLicencia);
    }
} else {
    $statement = $conexion->getCalendarioCitas($tipoLicencia);
}

$datosCalendario = $statement->fetchAll();

/* Si el resultado contiene un resultado, lo devolvemos */
if ($datosCalendario != null) {
    echo json_encode($datosCalendario);
}

/* Al terminar cerramos la conexion */
$conexion->desconectar();
