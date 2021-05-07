<?php
require_once("../conn/conexionBBDD.php");
session_start();

/* Obtenemos el campo que hemos pasado desde JQuery */
$tipoLicencia = $_POST['tipoLicencia'];
$fecha = $_POST['fecha'];
$numeroCitas = $_POST['numeroCitas'];

/* Crecamos la conexion y lanzamos la consulta previamente diseñada */
$conexion = new conexionBBDD();
$statement = $conexion->insertarCita($tipoLicencia, $fecha, $numeroCitas);
$resultado = $statement->fetchAll();

/* Devolvemos el resultado */
echo json_encode($resultado);

/* Al terminar cerramos la conexion */
$conexion->desconectar();
