$(document).ready(function(){
    global.generaSubmenu();

    $("#subemnus").on('change','input[name=options]',function () {
        global.cargarContenido(global.DIV_CONTAINER, $(this).val());
    });
});