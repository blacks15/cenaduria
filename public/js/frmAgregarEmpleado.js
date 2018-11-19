$(document).ready(function () {
    initialComponent();

    $("#btnPaso2").on('click', function () {
        var campos = $('#profile').find(':input[type="text"], select');

        //if (global.validarCamposWizard(campos)) {
        global.cambiarTab('profile-tab', 'address-tab', '49.494616', 'address', 'cp');
        //}
    });

    $("#btnAnt").on('click', function () {
        global.cambiarTab('address-tab', 'profile-tab', '16.161616', 'profile', 'nombreEmpleado');
    });

    $("#btnPaso3").on('click', function () {
        // var campos = $('#address').find(':input[type="text"], select');

        // if ( global.validarCamposWizard(campos) ) {
        global.cambiarTab('address-tab', 'contact-tab', '82.827616', 'contact', 'tel1');
        //}
    });

    $("#btnAnt2").on('click', function () {
        global.cambiarTab('contact-tab', 'address-tab', '49.494616', 'address', 'cp');
    });

    $("#btnSave").on('click', function () {
        if (validaContacto()) {
            var cadena = global.toJSON("#frmAgregarEmpleado");
            cadena.coloniaText = $("#colonias option:selected").text();

            cadena = JSON.stringify(cadena);
            var parametros = {
                cadena
            };
            enviarDatos(parametros);
        }
        //alert( $('#tel1').cleanVal()  );
    });
    /////////////////////////////////////////
    //              EVENTOS                //
    /////////////////////////////////////////
    $("#nombreEmpleado").on('keypress', function (event) {
        if (((document.all) ? event.keyCode : event.which) != 13) {
            return basicJs.soloLetras(event);
        }
    });

    $("#snombreEmpleado").on('keypress', function (event) {
        if (((document.all) ? event.keyCode : event.which) != 13) {
            return basicJs.soloLetras(event);
        }
    });

    $("#apaterno").on('keypress', function (event) {
        if (((document.all) ? event.keyCode : event.which) != 13) {
            return basicJs.soloLetras(event);
        }
    });

    $("#amaterno").on('keypress', function (event) {
        if (((document.all) ? event.keyCode : event.which) != 13) {
            return basicJs.soloLetras(event);
        }
    });

    $('#genero').data('selectpicker').$button.on('keydown', function (e) {
        if (((document.all) ? event.keyCode : event.which) == 13) {
            var selected = $('#genero').val();

            if ($.trim(selected) != '') {
                $("#rfc").focus();
            }
        }
    });

    $("#rfc").on('keypress', function (event) {
        if (((document.all) ? event.keyCode : event.which) != 13) {
            if (basicJs.validaRFC($(this).val())) {
                global.mensaje('Advertencia', 'warning', 'El Formato del RFC no es Correcto, Favor de Verificar.');
            }
        } else {
            return basicJs.numerosLetras(event);
        }
    });

    $('#puesto').data('selectpicker').$button.on('keydown', function (e) {
        if (((document.all) ? event.keyCode : event.which) == 13) {
            var selected = $('#puesto').val();

            if ($.trim(selected) != '') {
                $("#btnPaso2").focus();
            }
        }
    });

    $("#cp").on('keypress', function (event) {
        var codigoPostal = $.trim($(this).val());

        if (((document.all) ? event.keyCode : event.which) == 13) {
            if (codigoPostal == '') {
                limpiarcampos();
                global.mensaje('Advertencia', 'warning', 'Debe Ingresar un Código Postal.');
                return;
            } else if (codigoPostal.length < 5) {
                limpiarcampos();
                global.mensaje('Advertencia', 'warning', 'El Código Postal debe ser de 5 digitos.');
                return;
            } else {
                global.buscarCodigoPostal(codigoPostal, 'colonias', 'estado', 'ciudad');
                $("#colonias").focus();
            }
        } else {
            return basicJs.soloNumeros(event);
        }
    });

    $('#colonias').data('selectpicker').$button.on('keydown', function (e) {
        if (((document.all) ? event.keyCode : event.which) == 13) {
            var selected = $('#colonias').val();

            if ($.trim(selected) != '') {
                $("#calle").focus();
            }
        }
    });

    $("#calle").on('keypress', function (event) {
        if (((document.all) ? event.keyCode : event.which) != 13) {
            return basicJs.numerosLetrasEsp(event);
        }
    });

    $("#numExt").on('keypress', function (event) {
        if (((document.all) ? event.keyCode : event.which) != 13) {
            return basicJs.soloNumeros(event);
        }
    });

    $("#numInt").on('keypress', function (event) {
        if (((document.all) ? event.keyCode : event.which) != 13) {
            return basicJs.numerosLetras(event);
        }
    });

    $("#referencia").on('keypress', function (event) {
        if (((document.all) ? event.keyCode : event.which) != 13) {
            return basicJs.numerosLetrasEsp(event);
        }
    });
    /////////////////////////////////////////
    //              FUNCIONES              //
    /////////////////////////////////////////
    function initialComponent() {
        global.initialNavigation();
        global.initialSelect('selectpicker');
        global.initialCalendar('fechaNac');
        global.initialTooltip("data-toggle");
        global.initialMaskPhone('phoneMask');
        global.initialMakMoney('moneyMask');
        $("#nombreEmpleado").focus();
        cargarSelect();
    }

    function cargarSelect() {
        $.when(basicJs.enviarAjax(rutas.EMPLEADO_FILTER, '')).then(function (response, textStatus, jqXHR) {
            if (jqXHR.status == '200') {
                if (response.codRetorno == '000') {
                    global.limpiarSelectpicker("puesto");
                    $.each(response.puestos, function (index, value) {
                        global.agregarOpcionesSelect(value.idPuesto, value.puesto, 'puesto');
                    });
                    $.each(response.generos, function (index, value) {
                        global.agregarOpcionesSelect(value.idGenero, value.genero, 'genero');
                    });
                }
            } else {
                global.mensaje('', 'error', 'Ha Ocurrido un Error, Intentelo más Tarde.');
            }
        });
    }

    function enviarDatos(parametros) {
        $.when(basicJs.enviarAjax(rutas.EMPLEADO_SAVE, parametros)).then(function (response, textStatus, jqXHR) {
            if (jqXHR.status == '200') {
                if (response.codRetorno == '000') {
                    $(".progress-bar").css('width', '100%');
                    $(".nav-link").removeClass('active');
                }
            } else {
                global.mensaje('', 'error', 'Ha Ocurrido un Error, Intentelo más Tarde.');
            }
        });
    }

    function validaContacto() {
        var tel1 = $("#tel1").val();
        var tel2 = $("#tel2").val();
        var cel = $("#cel").val();
        var email = $("#email").val();
        var resp = false;

        if (tel1 == '' && tel2 == '' && cel == '') {
            global.mensajeValiacion('', 'info', '¡Debe Ingresar al menos un Teléfono de Contacto!.', 'tel1');
        } else if (email != '' && !basicJs.validarCorreo(email)) {
            global.mensajeValiacion('', 'info', '¡Debe Ingresar un Correo Electrónico Valido!.', 'email');
        } else {
            resp = true;
        }

        return resp;
    }

    function limpiarcampos() {
        $("#ciudad").val("");
        $("#estado").val("");
        global.limpiarSelectpicker("colonias");
    }
});