$(document).ready(function () {

    $("#buscar").focus();

    $("#buscar").on('keyup', function () {
        var rex = new RegExp($(this).val(), 'i');
        $('#ventasDiarias tr').hide();
        $('#ventasDiarias tr').filter(function () {
            return rex.test($(this).text());
        }).show();
    });

    $("#ventasDiarias").on('click', 'tr td .btnVer', function () {
        array = [];
        $(this).parents("tr").find("td").each(function () {
            array.push($(this).text());
        });

        $('#myModal').modal({
            handleUpdate: true,
            backdrop: 'static',
            keyboard: false
        })

        $("#vFolio").val(array[0]);

        $("#detalleVenta").html(crearFila());

        //console.log("edit " + array);
        array.length = 0;
    });

    function crearFila() {
        body = "";

        for (var i = 0; i < 7; i++) {
            body += ('<tr>');
            body += ('<td class="text-center w-15">001</td>');
            body += ('<td class="text-center w-30">Playera roja</td>');
            body += ('<td class="text-center w-20">$500</td>');
            body += ('<td class="text-center w-15">5</td>');
            body += ('<td class="text-center w-15">$2500</td>');
            body += ('</tr>');
        }

        return body;
    }
});