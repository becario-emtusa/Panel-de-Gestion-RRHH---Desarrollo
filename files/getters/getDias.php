<?php
require_once("../conn/conexionBBDD.php");
session_start();

/* Obtenemos el campo que hemos pasado desde JQuery */
$dni = $_POST['identificador'];
$tipoLicencia = $_POST['tipoLicencia'];

/* Crecamos la conexion y lanzamos la consulta previamente diseñada */
$conexion = new conexionBBDD();

/* Obtenemos los datos personales del usuario {
        Nombre,
        Apellidos,
        Departamento,
        Categoria
    } */
$statement = $conexion->getDiasDisponibles($dni, $tipoLicencia);
$datosPersona = $statement->fetchAll();

if ($datosPersona != null)
    echo json_encode($datosPersona);

/* Al terminar cerramos la conexion */
$conexion->desconectar();
