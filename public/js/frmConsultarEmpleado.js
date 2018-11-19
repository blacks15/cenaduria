$(document).ready(function () {
    var objetos = {
        "empleado": [
            { "id": "1", "nombre": "Jorge", "nombre2": " luis", "ap": "lopez", "am": "perez", "calle": "sindicalismo", "ni": "4818", "ne": "$1050", "perfil": "admin" },
            { "id": "2", "nombre": "Jorge", "nombre2": " luis", "ap": "lopez", "am": "perez", "calle": "sindicalismo", "ni": "4818", "ne": "$5000", "perfil": "admin" },
            { "id": "3", "nombre": "Jorge", "nombre2": " luis", "ap": "lopez", "am": "perez", "calle": "sindicalismo", "ni": "4818", "ne": "$3500", "perfil": "admin" },
            { "id": "4", "nombre": "Jorge", "nombre2": " luis", "ap": "lopez", "am": "perez", "calle": "sindicalismo", "ni": "4818", "ne": "$4100", "perfil": "admin" },
            { "id": "5", "nombre": "Jorge", "nombre2": " luis", "ap": "lopez", "am": "perez", "calle": "sindicalismo", "ni": "4818", "ne": "$2500", "perfil": "admin" },
        ]
    };

    var objetos2 = {
        "empleado": [
            { "id": "6", "nombre": "Jorge", "nombre2": " luis", "ap": "lopez", "am": "perez", "calle": "sindicalismo", "ni": "4818", "ne": "$2500", "perfil": "admin" },
            { "id": "7", "nombre": "Jorge", "nombre2": " luis", "ap": "lopez", "am": "perez", "calle": "sindicalismo", "ni": "4818", "ne": "$4100", "perfil": "admin" },
            { "id": "8", "nombre": "Jorge", "nombre2": " luis", "ap": "lopez", "am": "perez", "calle": "sindicalismo", "ni": "4818", "ne": "$4100", "perfil": "admin" },
            { "id": "9", "nombre": "Jorge", "nombre2": " luis", "ap": "lopez", "am": "perez", "calle": "sindicalismo", "ni": "4818", "ne": "$3500", "perfil": "admin" },
            { "id": "10", "nombre": "Jorge", "nombre2": " luis", "ap": "lopez", "am": "perez", "calle": "sindicalismo", "ni": "4818", "ne": "$3500", "perfil": "admin" },
        ]
    };

    $("input[name=buscarEmpleado]").change(function () {
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
            $("#table").append("<td class='text-center w-10'><span class='fa fa-edit'></span><span class='fa fa-trash-alt'></span></td></tr>");
        });
        numfilas = (objetos.empleado.length) + (objetos2.empleado.length);
        paginacion = global.obtenerPaginacion(numfilas, paginaActual);

        $("#paginate").html(paginacion);
    }

    function mostrarOpcion(mostrar) {
        if (mostrar == 'buscarNumEmp') {
            $("#buscarNumEmp").removeClass('d-none');
            $("#buscarNombreEmp").addClass('d-none');
            $("#numEmpleado").focus();
        } else if (mostrar == 'buscarNombreEmp') {
            $("#buscarNumEmp").addClass('d-none');
            $("#buscarNombreEmp").removeClass('d-none');
            $("#nombreEmpleado").focus();
        } else {
            $("#buscarNombreEmp").addClass('d-none');
            $("#buscarNumEmp").addClass('d-none');
        }
    }
});