$(function() {
    $("#buscar").focus();

    function buscar() {
        $.post(url + 'produccion/buscador', 'descripcion=' + $("#buscar").val() + '&filtro=' + $("#filtro").val(), function(datos) {
            var HTML = '<table id="table" class="table table-striped table-bordered table-hover sortable">' +
                    '<thead>' +
                    '<tr>' +
                    '<th>Item</th>' +
                    '<th>Encargado</th>' +
                    '<th>Nro Documento</th>' +
                    '<th>Tipo Documento</th>' +
                    '<th>Estado</th>' +
                    '<th>Acciones</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>';

            for (var i = 0; i < datos.length; i++) {
                HTML = HTML + '<tr>';
                HTML = HTML + '<td>' + (i + 1) + '</td>';
                HTML = HTML + '<td>' + datos[i].ENOMBRE +' '+datos[i].EAPELLIDO + '</td>';
                HTML = HTML + '<td>' + datos[i].NRODOC + '</td>';
                HTML = HTML + '<td>' + datos[i].TTIPOCOMPROBANTE + '</td>';
                if(datos[i].ESTADOPRODUCCION == 0){
                    HTML = HTML + '<td style="background: red"></td>';
                }else{
                    HTML = HTML + '<td style="background: green"></td>';
                }
                var eliminar = url + 'produccion/eliminar/' + datos[i].ID_PRODUCCION;
                HTML = HTML + '<td>';
                HTML = HTML + '<a href="#myModal" role="button" data-toggle="modal" title="ver" onclick="ver(\''+datos[i].ID_PRODUCCION+'\')" class="btn btn-warning btn-minier"><i class="icon-eye-open icon-white"></i></a>';
                if(datos[i].ESTADOPRODUCCION == 0){
                HTML = HTML + '<a href="'+url+'produccion/entregar/'+datos[i].ID_PRODUCCION+'" title="Entregar Produccion" class="btn btn-success btn-minier"><i class="icon-refresh icon-white"></i></a>';
                HTML = HTML + '<a href="javascript:void(0)" onclick="eliminar(\'' + eliminar + '\')" class="btn btn-danger btn-minier"><i class="icon-remove icon-white"></i></a>';
                }
                HTML = HTML + '</td>';
                HTML = HTML + '</tr>';
            }
            HTML = HTML + '</tbody></table>'
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
    var titulo = '', html = '';
    $("#myModalLabel").html('');
    $("#bodymodal").html('<div class="text-center"><img src="' + url + 'lib/img/loading.gif" /></div>');
    $.post(url + 'produccion/ver', 'id_produccion=' + id, function(response) {
        var datos = response.produccion;
        titulo += 'Datos de la Produccion';
        html += '<table class="table table-striped table-bordered table-hover sortable">';
        html += '<tr>';
        html += '<td>Empleado:</td>';
        html += '<td>' + datos[0]['ENOMBRE']+' '+datos[0]['EAPELLIDO'] + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td>Fecha Inicio:</td>';
        html += '<td>' + datos[0]['FECHA_INICIO'] + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td>Fecha Programada:</td>';
        html += '<td>' + datos[0]['FECHA_PROGRAMADA'] + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td>Estado Produccion:</td>';
        if(datos[0]['ESTADOPRODUCCION'] == 0){
            html += '<td>Pendiente</td>';
        } else {
            html += '<td>Terminada</td>';
        }
        html += '</tr>';
        html += '<tr>';
        html += '<td>Nro Doc. Venta:</td>';
        html += '<td>' + datos[0]['NRODOC'] + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td>Tipo Comprobante Venta:</td>';
        html += '<td>' + datos[0]['TTIPOCOMPROBANTE'] + '</td>';
        html += '</tr>';
        html += '</table>';
        html += '<p>Detalle Produccion</p>';
        html += '<table class="table table-striped table-bordered table-hover sortable">';
        html += '<tr>';
        html += '<th>Item</th>';
        html += '<th>Insumo</th>';
        html += '<th>Unidad Medida</th>';
        html += '<th>Cantidad</th>';
        html += '</tr>';
        
        var detproducinsumo = response.detproducinsumo;
        for (var i = 0; i < detproducinsumo.length; i++) {
            html += '<tr>';
            html += '<td>' + (i + 1) + '</td>';
            html += '<td>' + detproducinsumo[i]['IINSUMO'] + '</td>';
            html += '<td>' + detproducinsumo[i]['UUM'] + '</td>';
            html += '<td>' + detproducinsumo[i]['CANTIDADUM'] + '</td>';
            html += '</tr>';
        }
        html += '</table>';

        $("#myModalLabel").html(titulo);
        $("#bodymodal").html(html);
    }, 'json');
}