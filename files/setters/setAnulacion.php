<?php
/* Necesario incluir el fichero de conexion a la BBDD */
require_once("../conn/conexionBBDD.php");
session_start();

/* Obtenemos el campo que hemos pasado desde JQuery */
$num_solicitud = $_POST['num_solicitud'];

if (isset($_POST['admin'])) {
    $admin = 1;
} else {
    $admin = 0;
}

/* Crecamos la conexion y lanzamos la consulta previamente diseñada */
$conexion = new conexionBBDD();
$statement = $conexion->setAnulacion($num_solicitud, $admin);
$resultado = $statement->fetchAll();

if ($resultado != null)
    echo json_encode($resultado);

/* Al terminar cerramos la conexion */
$conexion->desconectar();
