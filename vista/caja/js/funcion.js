$(function() {
    $("#buscar").focus();
    $("#fecha_rep").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true
    });

    $("#rep_mov").click(function() {
        if ($("#fecha_rep").val() != '') {
            setTimeout("window.open('" + url + "caja/movimientos_fecha/" + $("#fecha_rep").val() + "')", 0);
        } else {
            $("#fecha_rep").focus();
        }
    });

    function buscar() {
        $.post(url + 'caja/buscador', 'descripcion=' + $("#buscar").val() + '&filtro=' + $("#filtro").val(), function(datos) {
            HTML = '<table id="table" class="table table-striped table-bordered table-hover sortable">' +
                    '<thead><tr>' +
                    '<th style="display: none"></th><th>Empleado</th>' +
                    '<th>Fecha y Hora de  Apertura</th>' +
                    '<th>Saldo de Apertura</th>' +
                    '<th>Fecha y Hora de  Cierre</th>' +
                    '<th>Saldo de Cierre</th>' +
                    '<th>Estado</th>' +
                    '</tr></thead><tbody>';

            for (var i = 0; i < datos.length; i++) {
                HTML += '<tr><td style="display: none"></td>';
                HTML += '<td>' + datos[i].EMPLEADO_N + ' ' + datos[i].EMPLEADO_A + '</td>';
                HTML += '<td>' + datos[i].A_FECHA + '</td>';
                HTML += '<td>' + datos[i].SALDO_AP + '</td>';
                if (datos[i].ESTADO == 1) {
                    HTML += '<td>Caja aún no Cerrada</td>';
                }
                else {
                    HTML += '<td>' + datos[i].C_FECHA + '</td>';
                }
                if (datos[i].ESTADO == 1) {
                    HTML += '<td>Caja aún no Cerrada</td>';
                }
                else {
                    HTML += '<td>' + datos[i].SALDO_CI + '</td>';
                }
                if (datos[i].ESTADO == 1) {
                    HTML += '<td>Aperturado</td>';
                }
                else {
                    HTML += '<td>Cerrado</td>';
                }
                HTML += '</tr>';
            }
            HTML += '</tbody></table>'
            $("#grilla").html(HTML);
            $("#jsfoot").html('<script src="' + url + 'vista/web/js/scriptgrilla.js"></script>');
        }, 'json');
    }
    $("#buscar").keyup(function(event) {
        buscar();
    });

    $("#btn_buscar").click(function() {
        buscar();
        $("#buscar").focus();
    });

});