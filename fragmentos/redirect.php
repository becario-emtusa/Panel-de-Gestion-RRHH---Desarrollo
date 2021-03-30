<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
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
