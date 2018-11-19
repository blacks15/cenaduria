$(document).ready(function () {
    initialComponent();

    $("#btnLogin").on('click', function () {
        var cadena = JSON.stringify(global.toJSON("#frmLogin"));
        var parametros = {
            cadena
        };
        login(parametros);
    });

    $("#usuario").on('keypress', function (evt) {
        var charCode = evt.which || evt.keyCode;

        if (charCode == 13 && $("#usuario").val() != '') {
            $("#password").focus();
        } else {
            return basicJs.numerosLetrasSig(evt);
        }
    });

    $("#usuario").on('keyup', function (evt) {
        habilitarBoton();
    });

    $("#password").on('keypress', function (evt) {
        var charCode = evt.which || evt.keyCode;

        if (charCode == 13 && $("#usuario").val() != '') {
            $("#btnLogin").focus();
        } else {
            return basicJs.numerosLetrasSig(evt);
        }
    });

    $("#password").on('keyup', function () {
        habilitarBoton();
    });

    function initialComponent() {
        $("#usuario").focus();
        $(".copyright").append('© ' + new Date().getFullYear() + ', Web Developer');
    }

    function habilitarBoton() {
        var campos = new Array();

        campos.push($("#usuario").val());
        campos.push($("#password").val());

        if (global.validarCampos(campos) ) {
            $("#btnLogin").prop('disabled', true);
        } else {
            $("#btnLogin").prop('disabled', false);
        }
    }

    function login(parametros) {
        $.when(basicJs.enviarAjax( rutas.LOGIN , parametros)).then(function (response, textStatus, jqXHR) {
            if (jqXHR.status == '200') {
                if (response.codRetorno == '000') {
                    global.saveJWT(response.jwt);
                    global.mensajeConfirm(response.titulo, 'success', response.mensaje, 'home');
                } else {
                    global.mensaje(response.titulo, 'warning', response.mensaje);
                }
            } else {
                global.mensaje('', 'error', 'Ha Ocurrido un Error, Intentelo más Tarde.');
            }
        });
    }
});