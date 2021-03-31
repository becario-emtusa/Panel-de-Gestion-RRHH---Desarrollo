<link rel="stylesheet" href="/dist/css/inicio-admin.css">

<div class="contenido-tabla">
    <div class="solicitudes">
    </div>
</div>

<script src="../dist/js/inicio-admin.js"></script>

<script>
    generar_resumen(<?php echo "'" . $_SESSION['Departamento'] . "'" ?>);
</script>