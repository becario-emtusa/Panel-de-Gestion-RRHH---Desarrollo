<?php
require_once("../conn/conexionBBDD.php");
session_start();

/* Obtenemos el campo que hemos pasado desde JQuery */
$fecha = $_POST['fecha'];

/* Crecamos la conexion y lanzamos la consulta previamente diseñada */
$conexion = new conexionBBDD();

/* Obtenemos los datos personales del usuario */
$statement = $conexion->getDatosCita($fecha);
$datosCita = $statement->fetchAll();

/* Si el resultado contiene un resultado, lo devolvemos */
if ($datosCita != null) {
    echo json_encode($datosCita);
}

/* Al terminar cerramos la conexion */
$conexion->desconectar();
