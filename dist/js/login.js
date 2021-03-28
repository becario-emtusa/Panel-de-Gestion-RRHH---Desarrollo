function recibir_login() {
    const usuario = document.querySelector('#username');
    const password = document.querySelector('#password');
    var data_string = 'usuario=' + usuario.value + '&password=' + password.value;

    $.ajax({
        type: "POST",
        data: data_string,
        url: './fragmentos/datos_login.php',
        success: function (data) {
            resultado = JSON.parse(data)["Resultado"];

            if (resultado === '1') {
                window.location.href = './inicio';
            } else {
                alert("Datos incorrectos, revíselos.");
            }
        },
        error: function () {
            alert("FAIL");
        }
    })
}

$(function () {
    $("#boton-submit").click(function (e) {
        e.preventDefault();
        recibir_login();
    });
});
