<link rel="stylesheet" href="/dist/css/inicio-admin.css">

<header>
    <div class="titulo">
        <h2>INICIO</h2>
    </div>
</header>

<div class="filtros" style="display: none; visibility: none;">
    <label>Ordenar por:</label>
    <select id="tipoOrden">
        <option value="solicitud">Tipo de Solicitud</option>
        <option value="fechaSolicitud">Fecha de Solicitud</option>
        <option value="fechaSolicitada">Fecha Solicitada</option>
        <option value="estado">Estado</option>
    </select>

    <label>Mostrar:</label>

    <select id="numDias">
        <option value="15">15 días</option>
        <option value="20">20 días</option>
        <option value="25">25 días</option>
        <option value="30">30 días</option>
    </select>

    <button id="filtrarContenido">Filtrar</button>
</div>

<div class="contenido-tabla">
    <div class="solicitudes">
    </div>
</div>
<div class="avanzar-tabla">
    <button id="prev"><i class="fas fa-arrow-alt-circle-left fa-lg"></i></button>
    <button id="next"><i class="fas fa-arrow-alt-circle-right fa-lg"></i></button>
</div>
<script src="/dist/js/inicio-admin.js"></script>

<script>
    generar_resumen(<?php echo "'" . $_SESSION['Departamento'] . "'" ?>);
</script>