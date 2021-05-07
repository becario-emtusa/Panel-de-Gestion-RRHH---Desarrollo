<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_COOKIE['emtusa-huelva']) && isset($_SESSION['login'])) {
    try {
        session_start();
        unset($_SESSION['login']);
        unset($_SESSION['Nombre']);
        unset($_SESSION['Apellidos']);
        unset($_SESSION['Departamento']);
        unset($_SESSION['Categoria']);
        session_destroy();
        header('Location: inicio');
        exit;
    } catch (Exception $e) {
        //
    }
}

if (!isset($_SESSION['login'])) {
    header("Location: login");
    exit;
}

if (isset($_SESSION['login'])) {
    $URI = $_SERVER['REQUEST_URI'];

    if ($_SESSION['login'] != 'ADMIN' && strpos($URI, 'admin') == '1') {
        header("Location: ../inicio");
        exit;
    }
}
