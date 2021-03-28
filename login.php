<!DOCTYPE html>
<html lang="es">
<link rel="stylesheet" href="/dist/css/login.css">

<?php
session_start();

if (isset($_SESSION['login'])) {
    header('Location: inicio');
    exit;
}

include './fragmentos/cabecera.php';
?>

<body>
    <?php
    include './fragmentos/menu.php';
    ?>

    <!-- Header -->
    <header>
        <h1>Introduzca los datos de usuario</h1>
    </header>

    <!-- Contenido -->
    <main>
        <form method="post" name="login-form">
            <div class="usuario">
                <a id="box"><i class="fas fa-user"></i></a><label>Usuario:</label>
                <input type="text" id="username" required />
            </div>
            <div class="password">
                <a id="box"><i class="fas fa-unlock-alt"></i></a><label>Contraseña:</label>
                <input type="password" id="password" required />
            </div>
            <button type="submit" id="boton-submit" name="login" value="login">Iniciar</button>
        </form>
    </main>

    <!-- Footer -->
    <?php
    include './fragmentos/footer.php';
    ?>

    <script src="../../dist/js/menu.js"></script>
    <script src="../../dist/js/login.js"></script>
</body>

</html>