<?php
if (!isset($_SESSION['login'])) {
    include 'menu-invitado.php';
} else {
    switch ($_SESSION['login']) {
        case 'ADMIN':
            include 'menu-administrador.php';
            break;
        default:
            include 'menu-usuario.php';
            break;
    }
}
