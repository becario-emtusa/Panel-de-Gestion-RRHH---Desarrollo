<!DOCTYPE html>
<html lang="es">

<?php
include "files/parts/redirect.php";
include "files/parts/cabecera.php";
?>

<link rel="stylesheet" href="/dist/css/gestion-citas.css">

<head>
    <title>Gestión de citas - EMTUSA Huelva</title>
</head>

<body>
    <?php
    include "files/parts/menu.php";
    ?>

    <header>
        <div class="titulo">
            <h2>GESTIÓN DE CITAS</h2>
        </div>
    </header>

    <main class="contenido">
        <h3>LISTADO DE CITAS ACTUALES:</h3>
        <div class="mostrar-citas">
            <div class="contenido-citas">
            </div>
        </div>
        <div class="acciones-disponibles">
            <div class="insercion-citas">
                <div class="title">
                    <h3>INSERCIÓN DE CITAS</h3>
                </div>
                <div class="datos-cita">
                    <div class="fecha">
                        <label>Fecha de la cita:</label>
                        <input type="date" id="fecha-input" value=<?php echo date('Y-m-d'); ?>>
                    </div>
                    <div class="hora">
                        <label>Hora de la cita:</label>
                        <input type="time" id="hora-cita" value="09:00">
                    </div>
                    <div class="num-citas">
                        <label>Número de citas para ese día:</label>
                        <div class="stepper-dias">
                            <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="decremento"><i class="fas fa-minus-circle"></i></button>
                            <input class="dia-input" id="dia-input" type="number" max="???" min="1" value="1" readonly>
                            <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="incremento"><i class="fas fa-plus-circle"></i></button>
                        </div>
                    </div>
                    <div class="generar-cita">
                        <button id="insertar-cita">Generar Cita</button>
                    </div>
                </div>
            </div>
            <div class="modificar-citas" style="visibility: none; display: none;">
                <div class="title">
                    <h3>MODIFICAR CITA</h3>
                </div>
                <div class="datos-cita">
                    <div class="fecha">
                        <label>Número de cita:</label>
                        <input type="number" id="cita-number-mod" disabled>
                    </div>
                    <div class="hora">
                        <label>Hora de la cita:</label>
                        <input type="text" id="hora_cita" disabled>
                    </div>
                    <div class="aptitud">
                        <label>Aptitud:</label>
                        <label class="switchAptitud">
                            <input type="checkbox" id="aptitud-valor">
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="acciones">
                        <button id="insertar-cita">Modificar Cita</button>
                        <button id="eliminar-cita">Eliminar Cita</button>
                    </div>
                </div>

            </div>
        </div>
    </main>
    <?php
    include 'files/parts/footer.php';
    ?>

    <script src="/dist/js/admin-gestion-citas.js"></script>
</body>

</html>