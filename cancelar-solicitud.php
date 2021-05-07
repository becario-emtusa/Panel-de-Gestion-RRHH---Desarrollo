<!DOCTYPE html>
<html lang="es">

<?php
include "files/parts/redirect.php";
include 'files/parts/cabecera.php';
?>

<link rel="stylesheet" href="/dist/css/crear-solicitudes-admin.css">

<head>
    <title>Creación de licencias - EMTUSA Huelva</title>
</head>

<body>
    <?php
    include 'files/parts/menu.php';
    ?>

    <header>
        <div class="titulo">
            <h2>CANCELACIÓN DE SOLICITUDES</h2>
        </div>
    </header>

    <main class="contenido">
        <div class="simple-">
            <div class="content1">
                <div class="datos-personal">
                    <div class="tarjeta-titulo">
                        <label>Datos de la solicitud</label>
                    </div>
                    <div class="datos-personal-mostrar">
                        <div id="datos-usuario">
                            <div class="informacion_usuario" id="div_nif">
                                <label>Número de solicitud</label>
                                <input type="text" id="identificador" placeholder="Introduzca el número de solicitud...">
                            </div>
                            <div class="informacion_usuario" id="div_nombre">
                                <label>Nombre del peticinario</label>
                                <input type="text" id="inputNombre" placeholder="..." readonly>
                            </div>
                            <div class="informacion_usuario" id="div_fecha">
                                <label>Fecha de la petición</label>
                                <input type="text" id="inputFechaSolicitud" placeholder="..." readonly>
                            </div>
                            <div class="informacion_usuario" id="div_estado">
                                <label>Estado de la petición</label>
                                <input type="text" id="inputEstado" placeholder="..." readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="enviar-datos">
            <button id="boton-datos">Cancelar Solicitud</button>
        </div>
        <div class="aviso_popup">
            <div class="contenido-popup">
                <p><strong id="texto-aviso"></strong></p>
                <div class="boton-cerrar-aviso">
                    <button class="cerrar" onclick="cerrar_aviso()">Cerrar aviso</button>
                </div>
            </div>
        </div>

    </main>

    <?php
    include 'files/parts/footer.php';
    ?>

    <script src="/dist/js/admin-cancelar-solicitud.js"></script>
</body>


</html>