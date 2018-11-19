$(document).ready(function () {
    var objetos = {
        "empleado": [
            { "id": "1", "empresa": "perfumería", "nombre": " perfumeria fina" },
            { "id": "2", "empresa": "relojería", "nombre": " relojeria fina" },
            { "id": "3", "empresa": "ropa caballero", "nombre": " ropa fina" },
            { "id": "4", "empresa": "ropa dama", "nombre": "ropa fina" },
            { "id": "5", "empresa": "electronica", "nombre": "aparatos electronicos" },
        ]
    };

    var objetos2 = {
        "empleado": [
            { "id": "6", "empresa": "muebles ", "nombre": " muebles" },
            { "id": "7", "empresa": "jugueteria", "nombre": "juguetes" },
            { "id": "8", "empresa": "zapateria", "nombre": " zapatos" },
        ]
    };

    $("input[name=buscaCategoria]").change(function () {
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
            var name; debugger;
            $("#table").html("<tr>");
            for (name in value) {
                $("#table").append("<td class='text-center'>" + value[name] + "</td>");
            }
            $("#table").append("<td class='text-center'><span class='fa fa-edit'></span><span class='fa fa-trash-alt'></span></td>");
            $("#table").html("</tr>");
        });
        numfilas = (objetos.empleado.length) + (objetos2.empleado.length);
        paginacion = global.obtenerPaginacion(numfilas, paginaActual);

        $("#thTable").addClass("striped");
        $("#paginate").html(paginacion);
    }

    function mostrarOpcion(mostrar) {
        if (mostrar == 'buscarNombreCategoria') {
            $("#buscarNombreCategoria").removeClass('d-none');
            $("#nombreCategoria").focus();
        } else {
            $("#buscarNombreCategoria").addClass('d-none');
        }
    }
});