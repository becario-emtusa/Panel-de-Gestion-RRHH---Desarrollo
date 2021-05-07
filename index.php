<!DOCTYPE html>
<html lang="es">
<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'files/parts/redirect.php';
include 'files/parts/cabecera.php';
?>

<head>
    <link rel="stylesheet" href="dist/css/inicio.css">
    <title>Inicio - EMTUSA Huelva</title>
</head>

<body>
    <?php
    include 'files/parts/menu.php';

    if (isset($_SESSION['login'])) {
        if ($_SESSION['login'] == 'ADMIN') {
            include 'files/parts/inicio-admin.php';
        } else {
            include 'files/parts/inicio-usuario.php';
        }
    }

    include 'files/parts/footer.php';
    ?>

    <script src="/dist/js/menu.js"></script>
</body>

</html>