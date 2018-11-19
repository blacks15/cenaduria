$(document).ready(function () {
    var objetos = {
        "empleado": [
            { "id": "1", "nombre": "Jorge", "nombre2": " luis", "ap": "lopez", "am": "perez", "calle": "sindicalismo", "ni": "4818", "ne": "A", "tipo_cliente": "contado" },
            { "id": "2", "nombre": "Jorge", "nombre2": " luis", "ap": "lopez", "am": "perez", "calle": "sindicalismo", "ni": "4818", "ne": "A", "tipo_cliente": "contado" },
            { "id": "3", "nombre": "Jorge", "nombre2": " luis", "ap": "lopez", "am": "perez", "calle": "sindicalismo", "ni": "4818", "ne": "A", "tipo_cliente": "crédito" },
            { "id": "4", "nombre": "Jorge", "nombre2": " luis", "ap": "lopez", "am": "perez", "calle": "sindicalismo", "ni": "4818", "ne": "A", "tipo_cliente": "crédito" },
            { "id": "5", "nombre": "Jorge", "nombre2": " luis", "ap": "lopez", "am": "perez", "calle": "sindicalismo", "ni": "4818", "ne": "A", "tipo_cliente": "contado" },
        ]
    };

    var objetos2 = {
        "empleado": [
            { "id": "6", "nombre": "Jorge", "nombre2": " luis", "ap": "lopez", "am": "perez", "calle": "sindicalismo", "ni": "4818", "ne": "A", "tipo_cliente": "crédito" },
            { "id": "7", "nombre": "Jorge", "nombre2": " luis", "ap": "lopez", "am": "perez", "calle": "sindicalismo", "ni": "4818", "ne": "A", "tipo_cliente": "contado" },
            { "id": "8", "nombre": "Jorge", "nombre2": " luis", "ap": "lopez", "am": "perez", "calle": "sindicalismo", "ni": "4818", "ne": "A", "tipo_cliente": "crédito" },
            { "id": "9", "nombre": "Jorge", "nombre2": " luis", "ap": "lopez", "am": "perez", "calle": "sindicalismo", "ni": "4818", "ne": "A", "tipo_cliente": "contado" },
            { "id": "10", "nombre": "Jorge", "nombre2": " luis", "ap": "lopez", "am": "perez", "calle": "sindicalismo", "ni": "4818", "ne": "A", "tipo_cliente": "crédito" },
        ]
    };

    $("input[name=buscarCliente]").change(function () {
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
        if (mostrar == 'buscarNumCli') {
            $("#buscarNumCli").removeClass('d-none');
            $("#buscarNombreCli").addClass('d-none');
            $("#numCliente").focus();
        } else if (mostrar == 'buscarNombreCli') {
            $("#buscarNumCli").addClass('d-none');
            $("#buscarNombreCli").removeClass('d-none');
            $("#nombreCliente").focus();
        } else {
            $("#buscarNombreCli").addClass('d-none');
            $("#buscarNumCli").addClass('d-none');
        }
    }
});