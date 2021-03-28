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

    <header>
        <div class="titulo">
            <h1>Bienvenido al portal de</br>Solicitud de Licencias de EMTUSA</h1>
        </div>
    </header>

    <main>
        <img id="imgPortada" src="dist/img/portada.jpg"></img>

        <?php
        if (!isset($_SESSION['login'])) {
            include './fragmentos/aviso-login.php';
        }
        ?>
    </main>

    <?php
    include './fragmentos/footer.php';
    ?>

    <script src="../../dist/js/menu.js"></script>
</body>

</html>