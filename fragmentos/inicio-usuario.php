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