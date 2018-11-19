$(document).ready(function () {
    obtenerMenu();

    function initial(usuario,menuPadre, menu){
        $.when( global.generaMenuSistema(menuPadre,menu),
            global.cargarMain(global.PAGES_CONTAINER,'bienvenido')
        ).then(function (response, textStatus, jqXHR) {
            $("#userName").text(usuario);
            global.initialTooltip("data-toggle");
        });
    }

    function cargarMenu() {
        var cadena = { "jwt" : localStorage.getItem('jwt') };

        cadena = JSON.stringify(cadena);

        var parametros = { cadena };

        $.when(basicJs.enviarAjax(rutas.MENU, parametros)).then(function (response, textStatus, jqXHR) {
            if (jqXHR.status == '200') {
                if (response.codRetorno == '000') {
                    initial(response.usuario,response.menuPadre,response.menu);
                } else if (response.codRetorno == '001') {
                    global.mensaje(response.codRetorno, 'warning', 'Ha Ocurrido un Error, Intentelo más Tarde.');
                } else {
                    global.mensajeConfirm(response.titulo, 'error', response.mensaje, 'login.html');
                }
            } else {
                global.mensaje('', 'error', 'Ha Ocurrido un Error, Intentelo más Tarde.');
            }
        });
    }

    function obtenerMenu(){
        $.when(
            global.cargarMain(global.MASTER_PAGE,'menu')
        ).then(function (response, textStatus, jqXHR) {
            cargarMenu()
        });
    }

    $("body").on('click', 'a.menu', function(){
        if (this.id != '') {
            localStorage.setItem('idMenu',$(this).attr("data"));
            global.cargarContenido(global.PAGES_CONTAINER, this.id );
        }
    });
});