$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $("#txtCodigoBuscar").focus();

    $('.selectpicker').selectpicker({
        style: 'btn-default',
    });

    $("#tableCompras").on('click', 'tr td .btnEliminar', function () {
        array = [];
        $(this).parents("tr").find("td").each(function () {
            array.push($(this).text());
        });

        console.log("del " + array);
        array.length = 0;
    });

    $("#tableCompras").on('click', 'tr td .btnEditar', function () {
        array = [];
        $(this).parents("tr").find("td").each(function () {
            array.push($(this).text());
            cantidad = $(this).find("input[name='txtCantidad_Id']").val();
            if (cantidad != undefined) {
                $(this).find("input[name='txtCantidad_Id']").prop('disabled', false);
                console.log("s " + cantidad);
            }
        });

        //console.log("edit " + array);
        array.length = 0;
    });

});