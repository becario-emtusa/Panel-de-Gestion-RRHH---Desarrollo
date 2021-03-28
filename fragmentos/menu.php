<?php
if (!isset($_SESSION['login'])) {
    include 'menu-invitado.php';
} else {
    include 'menu-usuario.php';
}
