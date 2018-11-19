var global = {
    cargarContenido: function (contenedor, pagina) {
        $("#" + contenedor).empty();
        $.ajax({
            cache: false,
            type: "GET",
            url: global.RUTA_PAGINAS + pagina,
            dataType: 'html',
            beforeSend: function () {
                basicJs.loading()
            },
            complete: function () {
                basicJs.ocultarEspere();
            },
            success: function (response) {
                $("#" + contenedor).html(response);
            },
            error: function (xhr, ajaxOptions, throwError) {
                console.log(xhr);
            }
        });
    },
    cargarMain: function (contenedor, pagina) {
        $.ajax({
            cache: false,
            type: "GET",
            url: global.RUTA_PAGINAS + pagina,
            dataType: 'html',
            beforeSend: function () {
                basicJs.loading()
            },
            complete: function () {
                basicJs.ocultarEspere();
            },
            success: function (response) {
                $("#" + contenedor).append(response);
            },
            error: function (xhr, ajaxOptions, throwError) {
                console.log(xhr);
            }
        });
    },
    cambiarTab: function (prevTab, nextTab, progress, tab, focus) {
        $("#" + prevTab).addClass('disabled');
        $("#" + prevTab).removeClass('active');
        $("#" + nextTab).removeClass('disabled');
        $("#pills-tab a[href='#" + tab + "']").tab('show');
        $(".progress-bar").css('width', progress + "%");
        global.cambiarFocoTab(focus);
    },
    cambiarFocoTab: function (campo) {
        $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
            $("#" + campo).focus();
        });
    },
    initialNavigation: function () {
        $(':input').on('keypress', function (e) {
            var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
            if (key == 13) {
                e.preventDefault();
                var inputs = $(this).closest('form').find(':input:visible:enabled');

                if ((inputs.length - 1) == inputs.index(this)) {
                    $(':input:enabled:visible:first').focus();
                } else {
                    inputs.eq(inputs.index(this) + 1).focus();
                }
            }
        });
    },
    initialSelect: function (selector) {
        $('.' + selector).selectpicker({
            style: 'btn-default',
        });
    },
    initialTooltip: function (data) {
        $('[' + data + '="tooltip"]').tooltip();
    },
    initialCalendar: function (selector) {
        $('#' + selector).datepicker({
            language: 'es',
            todayHighlight: true,
            autoclose: true,
            endDate: 'today',
            startDate: '-100y'
        });
    },
    initialFileInput: function (selector) {
        $("#" + selector).fileinput({
            language: "es",
            theme: "fas",
            showCaption: false,
            showRemove: false,
            showUpload: false,
            dropZoneEnabled: true,
            allowedFileExtensions: ["jpg", "png"],
            elErrorContainer: '#errorBlock',
            browseClass: "btn btn-success btn-block",
            browseLabel: "",
            browseIcon: "<i class=\"fa fa-fw fa-file-image\"></i> ",
        });
    },
    initialMaskPhone: function (selector) {
        $('.' + selector).mask('(000) 000-0000');
    },
    initialMakMoney: function (selector) {
        $('.' + selector).mask("000,000.00", { reverse: true });
    },
    obtenerFechaActual: function () {
        var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        f = new Date();
        fecha = f.getDate() + " de " + (meses[f.getMonth()]) + " de " + f.getFullYear();

        return fecha;
    },
    obtenerPaginacion: function (numFilas, paginaActual) {
        var lista = "";
        paginaActual = parseInt(paginaActual);
        totalPaginas = Math.ceil(numFilas / 5);

        if (paginaActual > 1) {
            lista = lista + "<li class='page-item'><a class='page-link' href='#' data=" + (paginaActual - 1) + " aria-label='Previous'>\
                <span aria-hidden='true'>&laquo;</span><span class='sr-only'>Previous</span></a></li>";
        }

        for (i = 1; i <= totalPaginas; i++) {
            if (i == paginaActual) {
                lista = lista + "<li class='page-item active'><a class='page-link' href='#' data=" + i + ">" + i + "</a></li>";
            } else {
                lista = lista + "<li class='page-item'><a class='page-link' href='#' data=" + i + ">" + i + "</a></li>";
            }
        }

        if (paginaActual < totalPaginas) {
            lista = lista + "<li class='page-item'><a class='page-link' href='#' data=" + (paginaActual + 1) + " aria-label='Siguiente'>\
                <span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span></a></li>";
        }

        return lista;
    },
    validarCampos: function (campos) {
        var resp = false;
        for (var i = 0; i < campos.length; i++) {
            if (campos[i] == "" || campos[i].length == 0) {
                resp = true;
                break;
            }
        }
        return resp;
    },
    validarCamposWizard: function (inputs) {
        var resp = true;
        inputs.each(function (index, element) {
            if ($.trim($(element).val()).length == 0 && $(element).prop('required')) {
                $(element).addClass('is-invalid');
                global.mensajeValiacion("Advertencia", "warning", "Debe llenar Todos los Campos Obligatorios.", element.id);
                resp = false;
                return false;;
            } else {
                $(element).removeClass('is-invalid');
            }
        });
        return resp;
    },
    mensaje: function (titulo, tipo, texto) {
        swal({
            title: titulo,
            type: tipo,
            text: texto,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
            allowEscapeKey: false,
            allowOutsideClick: false,
        });
    },
    mensajeValiacion: function (titulo, tipo, texto, element) {
        swal({
            title: titulo,
            type: tipo,
            text: texto,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
            allowEscapeKey: false,
            allowOutsideClick: false,
        }).then(function (isconfirm) {
            if (isconfirm) {
                $("#" + element).focus();
                return false;
            }
        });
    },
    mensajeConfirm: function (titulo, tipo, texto, pagina) {
        swal({
            title: titulo,
            type: tipo,
            text: texto,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
            allowEscapeKey: false,
            allowOutsideClick: false,
        }).then(function () {
            global.redirectPage(pagina);
        });
    },
    toJSON: function (selector) {
        var array = $(selector).serializeArray();
        var obj = {};
        for (var a = 0; a < array.length; a++) {
            obj[array[a].name] = basicJs.cleanString($.trim(array[a].value));
        }
        return obj;
    },
    redirectPage: function (page) {
        window.location.href = page;
    },
    saveJWT: function (jwt) {
        localStorage.jwt = jwt;
    },
    generaMenuSistema: function (menuPadre, menu) {
        var baseMenu = '<div class="sidebar" color="blue">\
                            <div class="sidebar-background sidebar-img"></div>\
                            <div class="sidebar-wrapper">\
                                <ul class="list-unstyled components">\
                                    <div id="menu" role="tablist">\</div>\
                                </ul>\
                            </div>\
                        </div>\
                    </div>';
        $(".wrapper").append(baseMenu);
        global.generaMenuPadre(menuPadre, menu);
    },
    generaMenuPadre: function (menuPadre, menu) {
        var menuP = "";
        $.each(menuPadre, function (index, value) {
            menuP += '<div class="tab" id="' + basicJs.quitarSpacios(value.padre) + 's" role="tab" >\
                        <a href="#'+ basicJs.quitarSpacios(value.padre) + '" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="' + basicJs.quitarSpacios(value.padre) + '">\
                            <i class="fa fa-'+ value.icono + '"></i>\
                            <i class="text text-capitalize">'+ value.padre + 's</i>\
                            <i class="fa fa-angle-down cus-icon-right"></i>\
                        </a>\
                    </div>\
                    <div class="collapse" id="'+ basicJs.quitarSpacios(value.padre) + '" role="tabpanel" aria-labelledby="' + basicJs.quitarSpacios(value.padre) + 's" data-parent="#menu">'
                + global.generaMenu(menu, value.id_padre) +
                '</div>'
        });
        $("#menu").append('<div>' + menuP + '</div>');
    },
    generaMenu: function (menu, idPadre) {
        var subM = "";
        $.each(menu, function (index, value) {
            if (idPadre == value.idPadre) {
                subM += '<ul class="list-unstyled">\
                            <li>\
                                <a href="#" class="text-capitalize menu" id="'+ basicJs.quitarSpacios(value.menu) + '" data="' + value.idMenu + '" >' + value.menu + '</a>\
                            </li>\
                        </ul>'
            }
        });
        return subM;
    },
    generaOpcion: function (subMenu) {
        var sub = "";
        $.each(subMenu, function (index, value) {
            sub += '<label class="btn btn-white col-xl-2 col-lg-4 col-md-6">\
                <input type="radio" class="text-capitalize" id="option1" name="options" value="'+ value.opcion + '" autocomplete="off">' + value.subMenu +
                '</label>';
        });

        $("#subemnus").append(sub);
    },
    generaSubmenu: function () {
        var cadena = { "jwt": localStorage.getItem('jwt'), "idMenu": localStorage.getItem('idMenu') };

        cadena = JSON.stringify(cadena);

        var parametros = { cadena };

        $.when(basicJs.enviarAjax(rutas.SUBMENU, parametros)).then(function (response, textStatus, jqXHR) {
            if (jqXHR.status == '200') {
                if (response.codRetorno == '000') {
                    global.generaOpcion(response.subMenu);
                } else {
                    global.mensajeConfirm(response.titulo, 'warning', response.mensaje, 'bienvenido');
                }
            } else {
                global.mensaje('', 'error', 'Ha Ocurrido un Error, Intentelo más Tarde.');
            }
        });
    },
    buscarColonias: function (cp) {
        return $.ajax({
            cache: false,
            type: "GET",
            crossDomain: true,
            url: global.RUTA_CODIGO_POSTAL + cp,
            dataType: 'json',
            beforeSend: function () {
                basicJs.loading()
            },
            complete: function () {
                basicJs.ocultarEspere();
            },
            success: function (res) {
                //El resultado se trabaja en los metodos individuales
            },
            error: function (xhr, ajaxOptions, throwError) {
                //El resultado se trabaja en los metodos individuales
            }
        });
    },
    buscarCodigoPostal: function (codigoPostal, select, estado, municipio) {
        campos = new Array(estado, municipio, select);
        global.limpiarFormulario(campos);
        global.limpiarSelectpicker(select);

        $.when(global.buscarColonias(codigoPostal)).then(function (response, textStatus, jqXHR) {
            if (jqXHR.status == '200') {
                if (response.colonias.length != 0 && response.estado != '') {
                    $("#" + municipio).val(response.municipio);
                    $("#" + estado).val(response.estado);
                    global.agregarOpcionesColoniasSelect(response.colonias, select);
                } else {
                    global.mensajeValiacion('Advertencia', 'warning', 'Códgio Postal Incorrecto, Favor de Verificarlo.', 'cp');
                }
            } else {
                global.mensaje('', 'error', 'Ha Ocurrido un Error, Intentelo más Tarde.');
            }
        });
    },
    agregarOpcionesColoniasSelect: function (datos, select) {
        $.each(datos, function (index, value) {
            var option = document.createElement("option");
            option.value = (index + 1);
            option.text = value;

            $("#" + select).append(option);
            $('#' + select).selectpicker('refresh');
        });
    },
    agregarOpcionesSelect: function (key, valor, select) {
        var option = document.createElement("option");
        option.value = key;
        option.text = valor;
        $("#" + select).append(option);
        $('#' + select).selectpicker('refresh');
    },
    limpiarSelectpicker: function (selector) {
        $('#' + selector + ' option').remove();
        $('#' + selector).selectpicker('refresh');
    },
    limpiarFormulario: function (campos) {
        for (var i = 0; i < campos.length; i++) {
            $("#" + campos[i]).val('');
        }
    },
    MASTER_PAGE: 'master',
    DIV_CONTAINER: 'contenedor',
    PAGES_CONTAINER: 'pagesContainer',
    RUTA_PAGINAS: 'http://localhost:8888/dash/pages/',
    RUTA_SERVICIOS: 'http://localhost:8888/dash/services/',
    RUTA_CODIGO_POSTAL: 'https://api-codigos-postales.herokuapp.com/v2/codigo_postal/',
};

$(document).ready(global);