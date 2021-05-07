<?php
require_once("../conn/conexionBBDD.php");
session_start();

/* Obtenemos el campo que hemos pasado desde JQuery */
$num_solicitud = $_POST['num_solicitud'];

/* Crecamos la conexion y lanzamos la consulta previamente diseñada */
$conexion = new conexionBBDD();

$statement = $conexion->getDatosSolicitud($num_solicitud);
$datos = $statement->fetchAll();

if ($datos != null)
    echo json_encode($datos);

/* Al terminar cerramos la conexion */
$conexion->desconectar();
