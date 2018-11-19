$(document).ready(function (params) {
    initialComponent();

    $("#codigoProducto").on('keypress', function (evt) {
        var charCode = evt.which || evt.keyCode;

        if (charCode == 13 && $("#codigoProducto").val() != '') {
            $("#nombreProducto").focus();
        } else {
            return basicJs.numerosLetras(evt);
        }
    });

    $("#nombreProducto").on('keypress', function (evt) {
        var charCode = evt.which || evt.keyCode;

        if (charCode == 13 && $("#nombreProducto").val() != '') {
            $("#proveedor").focus();
        } else {
            return basicJs.numerosLetras(evt);
        }
    });

    $("#proveedor").on('keypress', function (evt) {
        var charCode = evt.which || evt.keyCode;

        if (charCode == 13 && $("#proveedor").val() != '') {
            return e.keyCode = 9;
        }
    });

    function initialComponent() {
        global.initialFileInput("imagen");
        global.initialSelect("selectpicker");

        setInterval(function () {
            global.initialTooltip("data-tooltip");
        }, 900);

        $("#codigoProducto").focus();
    }
});