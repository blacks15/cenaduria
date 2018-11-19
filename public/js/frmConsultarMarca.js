$(document).ready(function () {
    var objetos = {
        "empleado": [
            { "id": "1", "empresa": "Versage", "nombre": " perfumeria fina" },
            { "id": "2", "empresa": "Versage", "nombre": " perfumeria fina" },
            { "id": "3", "empresa": "Versage", "nombre": " perfumeria fina" },
            { "id": "4", "empresa": "Paco Raban", "nombre": " perfumes españoles" },
            { "id": "5", "empresa": "Paco Raban", "nombre": " perfumes españoles" },
        ]
    };

    var objetos2 = {
        "empleado": [
            { "id": "6", "empresa": "perry elies", "nombre": " perfumes economicos" },
            { "id": "7", "empresa": "perry elies", "nombre": " perfumes economicos" },
            { "id": "8", "empresa": "perry elies", "nombre": " perfumes economicos" },
            { "id": "9", "empresa": "lacoste", "nombre": " perfumes juveniles" },
            { "id": "10", "empresa": "lacoste", "nombre": " perfumes juveniles" },
        ]
    };

    $("input[name=bucarMarca]").change(function () {
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
        if (mostrar == 'buscarNombreMarca') {
            $("#buscarNombreMarca").removeClass('d-none');
            $("#nombreMarca").focus();
        } else {
            $("#buscarNombreMarca").addClass('d-none');
        }
    }
});