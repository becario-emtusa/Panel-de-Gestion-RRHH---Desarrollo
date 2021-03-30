<!DOCTYPE html>
<html lang="es">
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include './fragmentos/cabecera.php';
?>

<head>
    <link rel="stylesheet" href="dist/css/inicio.css">
    <title>Inicio - EMTUSA Huelva</title>
</head>

<body>
    <?php
    include './fragmentos/menu.php';
    ?>

    <?php
    if (isset($_SESSION['login'])) {
        if ($_SESSION['login'] == 'ADMIN') {
            include './fragmentos/inicio-admin.php';
        } else {
            include './fragmentos/inicio-usuario.php';
        }
    }
    ?>

    <?php
    include './fragmentos/footer.php';
    ?>

    <script src="../../dist/js/menu.js"></script>
</body>

</html>