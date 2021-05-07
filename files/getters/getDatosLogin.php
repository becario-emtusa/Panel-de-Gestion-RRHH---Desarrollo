<?php
require_once("../conn/conexionBBDD.php");
session_start();
$usuario = $_POST["usuario"];
$password = md5($_POST["password"]);
$name = "emtusa-huelva";
$value = $password;

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

    /* La duración de la cookie es en segundos.
       La duración será de 36 horas. */
    setcookie($name, $usuario . ':' . $value, time() + 3600 * 36, '/');
} else if ($resultado->Resultado == 2) {
    $statement = $conexion->getDatosPersonal($usuario);
    $datos = $statement->fetch();

    $_SESSION['login'] = 'ADMIN';
    $_SESSION['Nombre'] = 'Administrador de';
    $_SESSION['Apellidos'] = ucfirst($datos->Usuario);
    $_SESSION['Departamento'] = ucfirst($datos->Usuario);
    $_SESSION['Categoria'] = 'Administrador';
    setcookie($name, $usuario . ':' . $value, time() + 3600 * 336, '/');
};

echo json_encode($resultado);

$conexion->desconectar();
