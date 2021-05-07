<!DOCTYPE html>
<html lang="es">
<link rel="stylesheet" href="/dist/css/login.css">

<?php
session_start();

if (isset($_SESSION['login'])) {
    header('Location: inicio');
    exit;
}

include 'files/parts/cabecera.php';
?>

<body>
    <?php
    include 'files/parts/menu.php';
    ?>

    <!-- Header -->
    <header>
        <h1>Inicio de sesión</h1>
    </header>

    <!-- Contenido -->
    <main>
        <form method="post" name="login-form">
            <div class="contenido">
                <div class="usuario">
                    <div class="label-usuario">
                        <a id="box"><i class="fas fa-user"></i></a><label>Usuario:</label>
                    </div>
                    <input type="text" id="username" required />
                </div>
                <div class="password">
                    <div class="label-password">
                        <a id="box"><i class="fas fa-unlock-alt"></i></a><label>Contraseña:</label>
                    </div>
                    <input type="password" id="password" required />
                </div>
            </div>
            <button type="submit" id="boton-submit" name="login" value="login">Iniciar</button>
        </form>
    </main>

    <!-- Footer -->
    <?php
    include 'files/parts/footer.php';
    ?>

    <script src="/dist/js/menu.js"></script>
    <script src="/dist/js/login.js"></script>
</body>

</html>