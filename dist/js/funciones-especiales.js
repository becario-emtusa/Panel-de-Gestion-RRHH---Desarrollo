function get_datos_usuario(nif) {
    $.ajax({
        type: "POST",
        data: "dni=" + nif,
        url: '/fragmentos/getDatos.php',
        success: function (data) {
            json_obj = JSON.parse(data);

            var p_nombre = document.querySelector('#nombre');

            //p_nombre.innerHTML = json_obj['Nombre'] + ' ' + json_obj['Apellidos'];


        },
        error: function () {
            console.log("Error");
        }
    });
}

/*
<script>
    $.getScript('/dist/js/funciones-especiales.js', function() {
        var $datos = get_datos_usuario('<?php echo $_SESSION["login"]; ?>');
    })
</script>
*/