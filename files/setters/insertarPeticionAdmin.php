<?php
require_once("../conn/conexionBBDD.php");
session_start();

/* Obtenemos el campo que hemos pasado desde JQuery */
$dni = $_POST['identificador'];
$tipoLicencia = $_POST['tipoLicencia'];
$fechaIni = $_POST['fechaIni'];
$fechaFin = $_POST['fechaFin'];

/* Crecamos la conexion y lanzamos la consulta previamente diseñada */
$conexion = new conexionBBDD();
$statement = $conexion->insertarPeticion($dni, $tipoLicencia, $fechaIni, $fechaFin, $admin = 1);
$resultado = $statement->fetchAll();

/* Devolvemos el resultado */
echo json_encode($resultado);

/* Al terminar cerramos la conexion */
$conexion->desconectar();
