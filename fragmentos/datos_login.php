<?php
require_once("./conexionBBDD.php");
session_start();
$usuario = $_POST["usuario"];
$password = md5($_POST["password"]);

$conexion = new conexionBBDD();

$statement = $conexion->comprobarLogin($usuario, $password);

$resultado = $statement->fetch();

if ($resultado->Resultado == 1) {
    $statement = $conexion->getDatosPersonal($usuario);
    $datos = $statement->fetch();

    $_SESSION['login'] = $datos->NIF;
    $_SESSION['Nombre'] = $datos->Nombre;
    $_SESSION['Apellidos'] = $datos->Apellidos;
    $_SESSION['Departamento'] = $datos->Departamento;
    $_SESSION['Categoria'] = $datos->Categoria;
};

echo json_encode($resultado);

$conexion->desconectar();
