$(function() {
    $("#buscar").focus();

    function buscar() {
        $.post(url + 'compra/buscador', 'descripcion=' + $("#buscar").val() + '&filtro=' + $("#filtro").val(), function(datos) {
            HTML = '<table id="table" class="table table-striped table-bordered table-hover table-condensed">' +
                    '<thead>' +
                    '<tr>' +
                    '<th>Item</th>' +
                    '<th>Nro Doc.</th>' +
                    '<th>Proveedor</th>' +
                    '<th>Fecha</th>' +
                    '<th>Acciones</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>';

            for (var i = 0; i < datos.length; i++) {
                HTML = HTML + '<tr>';
                HTML = HTML + '<td>' + (i + 1) + '</td>';
                HTML = HTML + '<td>' + datos[i].NRODOC + '</td>';
                HTML = HTML + '<td>' + datos[i].PPROVEEDOR + '</td>';
                HTML = HTML + '<td>' + datos[i].FECHACOMPRA + '</td>';
                var eliminar = url + 'compra/eliminar/' + datos[i].ID_COMPRA;
                HTML = HTML + '<td>';
                HTML = HTML + '<a href="#myModal" style="margin-right:4px" role="button" data-toggle="modal" onclick="ver(\'' + datos[i].ID_COMPRA + '\')" class="btn btn-warning btn-minier"><i class="icon-eye-open icon-white"></i></a>';
                if(datos[i].ESTADOPAGO == 0) {
                    HTML = HTML + '<a href="javascript:void(0)" onclick="eliminar(\'' + eliminar + '\')" class="btn btn-danger btn-minier"><i class="icon-remove icon-white"></i></a>';
                }
                HTML = HTML + '</td>';
                HTML = HTML + '</tr>';
            }
            HTML = HTML + '</tbody></table>';
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

function ver(id) {
    titulo = '', html = '';
    $("#myModalLabel").html('');
    $("#bodymodal").html('<div class="text-center"><img src="' + url + 'lib/img/loading.gif" /></div>');
    $.post(url + 'compra/ver', 'idcompra=' + id, function(datos) {
        titulo += 'Datos de la Compra';
        html += '<table class="table table-striped table-bordered table-hover sortable">';
        html += '<tr>';
        html += '<td>Nro.Documento:</td>';
        html += '<td>' + datos[0]['NRODOC'] + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td>Proveedor:</td>';
        html += '<td>' + datos[0]['PPROVEEDOR'] + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td>Fecha de Compra:</td>';
        html += '<td>' + datos[0]['FECHACOMPRA'] + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td>Tipo de Pago:</td>';
        html += '<td>' + datos[0]['TTIPOPAGO'] + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td>Importe:</td>';
        html += '<td>' + datos[0]['MONTO'] + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td>IGV:</td>';
        html += '<td>' + datos[0]['IGV'] + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td>Total:</td>';
        tot = (parseFloat(datos[0]['IGV']) + 1) * (datos[0]['MONTO']);
        html += '<td>' + (tot).toFixed(2) + '</td>';
        html += '</tr>';
        html += '</table>';
        html += '<p>Detalle Compra</p>';
        html += '<table  class="table table-striped table-bordered table-hover sortable">';
        html += '<tr>';
        html += '<th>Item</th>';
        html += '<th>Producto</th>';
        html += '<th>Unidad Medida</th>';
        html += '<th>Cantidad</th>';
        html += '<th>Precio</th>';
        html += '<th>Subtotal</th>';
        html += '</tr>';
        for (var i = 0; i < datos.length; i++) {
            html += '<tr>';
            html += '<td>' + (i + 1) + '</td>';
            html += '<td>' + datos[i]['PPRODUCTO'] + '</td>';
            html += '<td>' + datos[i]['UUM'] + '</td>';
            html += '<td>' + datos[i]['CANTIDADUM'] + '</td>';
            html += '<td>' + datos[i]['PRECIOUNITARIO'] + '</td>';
            html += '<td>' + (datos[i]['CANTIDADUM'] * datos[i]['PRECIOUNITARIO']).toFixed(2) + '</td>';
            html += '</tr>';
        }
        html += '</table>';

        $("#myModalLabel").html(titulo);
        $("#bodymodal").html(html);
    }, 'json');
}
