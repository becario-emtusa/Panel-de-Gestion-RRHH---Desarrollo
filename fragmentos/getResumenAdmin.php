<?php
/* Necesario incluir el fichero de conexion a la BBDD */
require_once("./conexionBBDD.php");
session_start();

/* Obtenemos el campo que hemos pasado desde JQuery */
$departamento = $_POST['departamento'];

/* Crecamos la conexion y lanzamos la consulta previamente diseñada */
$conexion = new conexionBBDD();

$statement = $conexion->getResumenAdmin($departamento);
$datos = $statement->fetchAll();

if ($datos != null)
    echo json_encode($datos);

/* Al terminar cerramos la conexion */
$conexion->desconectar();
