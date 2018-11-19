$(document).ready(function () {
    var objetos = {
        "empleado": [
            { "id": "1", "empresa": "Distribuidora del oeste", "nombre": " luis perez oso", "calle": "sindicalismo", "ni": "4818", "ne": "A", "c": "culiacan sinaloa", "tel": "6674589788" },
            { "id": "2", "empresa": "Distribuidora del oeste", "nombre": " luis perez oso", "calle": "sindicalismo", "ni": "4818", "ne": "A", "c": "culiacan sinaloa", "tel": "6674589788" },
            { "id": "3", "empresa": "Distribuidora del oeste", "nombre": " luis lopez", "calle": "sindicalismo", "ni": "4818", "ne": "A", "c": "culiacan sinaloa", "tel": "6671239567" },
            { "id": "4", "empresa": "Distribuidora del oeste", "nombre": " luis lopez", "calle": "sindicalismo", "ni": "4818", "ne": "A", "c": "culiacan sinaloa", "tel": "6671239567" },
            { "id": "5", "empresa": "Distribuidora del oeste", "nombre": " luis lopez", "calle": "sindicalismo", "ni": "4818", "ne": "A", "c": "culiacan sinaloa", "tel": "6674589788" },
        ]
    };

    var objetos2 = {
        "empleado": [
            { "id": "6", "empresa": "Leche lala", "nombre": " luis", "calle": "sindicalismo", "ni": "4818", "ne": "A", "c": "culiacan sinaloa", "tel": "6671239567" },
            { "id": "7", "empresa": "Leche lala", "nombre": " luis", "calle": "sindicalismo", "ni": "4818", "ne": "A", "c": "culiacan sinaloa", "tel": "6674589788" },
            { "id": "8", "empresa": "Leche lala", "nombre": " luis", "calle": "sindicalismo", "ni": "4818", "ne": "A", "c": "culiacan sinaloa", "tel": "6671239567" },
            { "id": "9", "empresa": "Leche lala", "nombre": " luis", "calle": "sindicalismo", "ni": "4818", "ne": "A", "c": "culiacan sinaloa", "tel": "6674589788" },
            { "id": "10", "empresa": "Leche lala", "nombre": " luis", "calle": "sindicalismo", "ni": "4818", "ne": "A", "c": "culiacan sinaloa", "tel": "6671239567" },
        ]
    };

    $("input[name=buscarSucursal]").change(function () {
        var opc = $(this).val();

        mostrarOpcion(opc);
    });

    $("#btnsearch").on('click', function () {
        $("#table").html("");
        $("#paginate").html("");
        construirTabla(objetos, 1);
    });

    $("#paginate").on('click', '.page-link', function (e) {
        e.preventDefault();
        $("#table").html("");
        $("#paginate").html("");
        var page = $(this).attr("data");

        if (page == 1) {
            construirTabla(objetos, page);
        } else {
            construirTabla(objetos2, page);
        }
    });

    function construirTabla(objetos, paginaActual) {
        $("#thTable").removeClass('d-none');
        $.each(objetos.empleado, function (index, value) {
            var name;
            $("#table").append("<tr>");
            for (name in value) {
                $("#table").append("<td class='text-center'>" + value[name] + "</td>");
            }
            $("#table").append("<td class='text-center'><span class='fa fa-edit'></span><span class='fa fa-trash-alt'></span></td></tr>");
        });
        numfilas = (objetos.empleado.length) + (objetos2.empleado.length);
        paginacion = global.obtenerPaginacion(numfilas, paginaActual);

        $("#paginate").html(paginacion);
    }

    function mostrarOpcion(mostrar) {
        if (mostrar == 'buscarNumSuc') {
            $("#buscarNumSuc").removeClass('d-none');
            $("#buscarNombreSuc").addClass('d-none');
            $("#numSucursal").focus();
        } else if (mostrar == 'buscarNombreSuc') {
            $("#buscarNumSuc").addClass('d-none');
            $("#buscarNombreSuc").removeClass('d-none');
            $("#nombreSucursal").focus();
        } else {
            $("#buscarNumSuc").addClass('d-none');
            $("#buscarNombreSuc").addClass('d-none');
        }
    }
});