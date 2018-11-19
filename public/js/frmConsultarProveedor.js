$(document).ready(function () {
    var objetos = {
        "empleado": [
            { "id": "MOMF900527HJ1", "empresa": "Distribuidora del oeste", "nombre": " luis lopez soto", "calle": "sindicalismo", "ni": "4818", "te": "Fisica", "tel": "6674589788", "cel": "6672154875" },
            { "id": "MOMF900527HJ2", "empresa": "Distribuidora del oeste", "nombre": " luis lopez soto", "calle": "sindicalismo", "ni": "4818", "te": "Moral", "tel": "6674589788", "cel": "6672154875" },
            { "id": "MOMF900527HJ3", "empresa": "Distribuidora del oeste", "nombre": " luis lopez soto", "calle": "sindicalismo", "ni": "4818", "te": "Fisica", "tel": "6671239567", "cel": "6672154875" },
            { "id": "MOMF900527HJ4", "empresa": "Distribuidora del oeste", "nombre": " luis lopez soto", "calle": "sindicalismo", "ni": "4818", "te": "Moral", "tel": "6671239567", "cel": "6672154875" },
            { "id": "MOMF900527HJ5", "empresa": "Distribuidora del oeste", "nombre": " luis lopez soto", "calle": "sindicalismo", "ni": "4818", "te": "Fisica", "tel": "6674589788", "cel": "6672154875" },
        ]
    };

    var objetos2 = {
        "empleado": [
            { "id": "MOMF900527HJ6", "empresa": "Leche lala", "nombre": " luis perez oso", "calle": "sindicalismo", "ni": "4818", "te": "Fisica", "tel": "6671239567", "cel": "6672154875" },
            { "id": "MOMF900527HJ7", "empresa": "Leche lala", "nombre": " luis perez oso", "calle": "sindicalismo", "ni": "4818", "te": "Moral", "tel": "6674589788", "cel": "6672154875" },
            { "id": "MOMF900527HJ8", "empresa": "Leche lala", "nombre": " luis perez oso", "calle": "sindicalismo", "ni": "4818", "te": "Fisica", "tel": "6671239567", "cel": "6672154875" },
            { "id": "MOMF900527HJ9", "empresa": "Leche lala", "nombre": " luis perez oso", "calle": "sindicalismo", "ni": "4818", "te": "Moral", "tel": "6674589788", "cel": "6672154875" },
            { "id": "MOMF900527H10", "empresa": "Leche lala", "nombre": " luis perez oso", "calle": "sindicalismo", "ni": "4818", "te": "Fisica", "tel": "6671239567", "cel": "6672154875" },
        ]
    };

    $("input[name=buscarProveedor]").change(function () {
        var opc = $(this).val();

        mostrarOpcion(opc);
    });

    $("#btnSearch").on('click', function () {
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
        if (mostrar == 'buscarNumProv') {
            $("#buscarNumProv").removeClass('d-none');
            $("#buscarNombreProv").addClass('d-none');
            $("#numProveedor").focus();
        } else if (mostrar == 'buscarNombreProv') {
            $("#buscarNumProv").addClass('d-none');
            $("#buscarNombreProv").removeClass('d-none');
            $("#nombreProveedor").focus();
        } else {
            $("#buscarNumProv").addClass('d-none');
            $("#buscarNombreProv").addClass('d-none');
        }
    }
});