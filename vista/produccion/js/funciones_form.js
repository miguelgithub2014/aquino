$(function() {
    $("input:text[readonly=readonly]").css('cursor', 'pointer');
    limpiar();
    $("#fecha_programada").datepicker({dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true});
    $("#save").click(function() {
        bval = true;
        bval = bval && $("#empleado").required();
        bval = bval && $("#venta").required();
        bval = bval && $("#fecha_programada").required();
        if (bval) {
            if ($(".row_tmp").length) {
                bootbox.confirm("¿Está seguro que desea guardar la produccion?", function(result) {
                    if (result) {
                        $("#frm").submit();
                    }
                });
            } else {
                bootbox.alert("Agregue los insumos al detalle");
            }
        }
        return false;
    });
    $("#selectInsumo").click(function() {
        buscarInsumo();
        $("#buscarInsumo").focus();
        $("#VtnBuscarInsumo").show();
    });
    $("#insumo").click(function() {
        buscarInsumo();
        $("#buscarInsumo").focus();
        $("#VtnBuscarInsumo").show();
        $("#buscarInsumo").focus();
    });
    $("#AbrirVtnBuscarInsumo").click(function() {
        buscarInsumo();
        $("#buscarInsumo").focus();
        $("#VtnBuscarInsumo").show();
        $("#buscarInsumo").focus();
    });
    $("#empleado").click(function() {
        buscarEmpleado();
        $("#buscarEmpleado").focus();
        $("#VtnBuscarEmpleado").show();
        $("#buscarEmpleado").focus();
    });
    $("#empleado").focus(function() {
        buscarEmpleado();
        $("#buscarEmpleado").focus();
        $("#VtnBuscarEmpleado").show();
        $("#buscarEmpleado").focus();
    });
    $("#AbrirVtnBuscarEmpleado").click(function() {
        buscarEmpleado();
        $("#buscarEmpleado").focus();
        $("#VtnBuscarEmpleado").show();
        $("#buscarEmpleado").focus();
    });
    $("#venta").click(function() {
        buscarVenta();
        $("#buscarVenta").focus();
        $("#VtnBuscarVenta").show();
        $("#buscarVenta").focus();
    });
    $("#venta").focus(function() {
        buscarVenta();
        $("#buscarVenta").focus();
        $("#VtnBuscarVenta").show();
        $("#buscarVenta").focus();
    });
    $("#AbrirVtnBuscarVenta").click(function() {
        buscarVenta();
        $("#buscarVenta").focus();
        $("#VtnBuscarVenta").show();
        $("#buscarVenta").focus();
    });
    //Insumo
    $("#buscarInsumo").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            buscarInsumo();
        }
    });
    $("#btn_buscarInsumo").click(function() {
        buscarInsumo();
        $("#buscarInsumo").focus();
    });
    //Empleado
    $("#buscarEmpleado").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            buscarEmpleado();
        }
    });
    $("#btn_buscarEmpleado").click(function() {
        buscarEmpleado();
        $("#buscarEmpleado").focus();
    });
    //Venta
    $("#buscarVenta").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            buscarVenta();
        }
    });
    $("#btn_buscarVenta").click(function() {
        buscarVenta();
        $("#buscarVenta").focus();
    });
    
    $("#cantidadum").keyup(function(){
        $("#id_unidadmedida").trigger('change');
    });
    
    $("#id_unidadmedida").change(function() {
        if($(this).val()!='0'){
            var cantidad = $("#cantidadum").val();
            cantidad = parseInt(cantidad);
            if (isNaN(cantidad)) {
                cantidad = 0;
            }
            var cantidadub = cantidad * parseInt($("#id_unidadmedida option:selected").attr('count'));
            $("#cantidadub").val(cantidadub);
        }else{
            $("#cantidadub").val('');
        }
    });
    
    $("#addDetalle").click(function() {
        var bval = true;
        bval = bval && $("#insumo").required();
        bval = bval && $("#id_unidadmedida").required();
        bval = bval && $("#cantidadum").required();
        if (bval) {
            if ($(".id_prod[value=" + $("#id_insumo").val() + "]").length) {
                bootbox.alert("Este insumo ya fue agregado");
                return false;
            }
            var stockactual = parseInt($("#stockactual").val());
            var cantidadub = parseInt($("#cantidadub").val());
            if(cantidadub > stockactual){
                bootbox.alert("No hay suficiente stock de insumo");
                return false;
            }
            var html = '<tr class="row_tmp">';
            html += '<td>';
            html += '   <input type="hidden" name="id_insumo[]" class="id_prod" value="' + $("#id_insumo").val() + '" />' + $("#insumo").val();
            html += '</td>';
            html += '<td>';
            html += '   <input type="hidden" name="id_unidadmedida[]" value="' + $("#id_unidadmedida option:selected").val() + '" />' + $("#id_unidadmedida option:selected").html();
            html += '</td>';
            html += '<td>';
            html += '   <input type="hidden" name="cantidadum[]" value="' + $("#cantidadum").val() + '" />' + $("#cantidadum").val();
            html += '   <input type="hidden" name="stockactual[]" value="' + stockactual.toString() + '" />';
            html += '   <input type="hidden" name="cantidadub[]" value="' + cantidadub.toString() + '" />';
            html += '</td>';
            html += '<td>';
            html += '   <a class="btn btn-danger delete"><i class="icon-trash icon-white"></i></a>';
            html += '</td>';
            html += '</tr>';

            $("#tblDetalle").append(html);
            limpiar();
        }
    });
    
    $(".delete").live('click', function() {
        var i = $(this).parent().parent().index();
        $("#tblDetalle tr:eq(" + i + ")").remove();
    });
    
});

function buscarInsumo() {
    $("#grillaInsumo").html('<div class="page-header"><img src="'+url+'lib/img/loading.gif" /></div>');
    $("#grillaVenta").html('<div class="page-header"><img src="'+url+'lib/img/loading.gif" /></div>');
    $("#grillaEmpleado").html('<div class="page-header"><img src="'+url+'lib/img/loading.gif" /></div>');
    $.post(url + 'insumo/buscador', 'cadena=' + $("#buscarInsumo").val() + '&filtro=' + $("#filtroInsumo").val(), function(datos) {
        var HTML = '<table id="table" class="table table-striped table-bordered table-hover sortable">' +
                '<thead>' +
                '<tr>' +
                '<th>Item</th>' +
                '<th>Insumo</th>' +
                '<th>Almacen</th>' +
                '<th>Unid. Med.</th>' +
                '<th>Stock</th>' +
                '<th>Prec. Compra</th>' +
                '<th>Acciones</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>';

        for (var i = 0; i < datos.length; i++) {
            HTML = HTML + '<tr>';
            HTML = HTML + '<td>' + (i + 1) + '</td>';
            HTML = HTML + '<td>' + datos[i].DESCRIPCION + '</td>';
            HTML = HTML + '<td>' + datos[i].AALMACEN + '</td>';
            HTML = HTML + '<td>' + datos[i].UUNIDADMEDIDA + '</td>';
            HTML = HTML + '<td>' + datos[i].STOCK + '</td>';
            HTML = HTML + '<td>' + datos[i].PRECIOC + '</td>';
            var idinsumo = datos[i].ID_INSUMO;
            var descripcion = datos[i].DESCRIPCION;
            var stock = datos[i].STOCK;
            var precioc = datos[i].PRECIOC;
            HTML = HTML + '<td><a style="margin-right:4px" href="javascript:void(0)" onclick="sel_insumo(\'' + idinsumo + '\',\'' + descripcion + '\',\'' + stock + '\',\'' + precioc + '\')" class="btn btn-success"><i class="icon-ok icon-white"></i> </a>';
            HTML = HTML + '</td>';
            HTML = HTML + '</tr>';
        }
        HTML = HTML + '</tbody></table>';
        $("#grillaInsumo").html(HTML);
        $("#jsfoot").html('<script src="' + url + 'vista/web/js/scriptgrilla.js"></script>');
    }, 'json');
}

function buscarEmpleado() {
    $("#grillaInsumo").html('<div class="page-header"><img src="'+url+'lib/img/loading.gif" /></div>');
    $("#grillaVenta").html('<div class="page-header"><img src="'+url+'lib/img/loading.gif" /></div>');
    $("#grillaEmpleado").html('<div class="page-header"><img src="'+url+'lib/img/loading.gif" /></div>');
    $.post(url + 'empleado/buscador', 'cadena=' + $("#buscarEmpleado").val() + '&filtro=' + $("#filtroEmpleado").val(), function(datos) {
        var HTML = '<table id="table" class="table table-striped table-bordered table-hover sortable">' +
                '<thead>' +
                '<tr>' +
                '<th>Item</th>'+
                '<th>Nombres</th>'+
                '<th>Apellidos</th>'+
                '<th>Usuario</th>'+
                '<th>Perfil</th>'+
                '<th>Acciones</th>'+
                '</tr>' +
                '</thead>' +
                '<tbody>';

        for (var i = 0; i < datos.length; i++) {
            HTML = HTML + '<tr>';
            HTML = HTML + '<td>' + (i + 1) + '</td>';
            var nombre = datos[i].NOMBRE;
            var apellido = datos[i].APELLIDO;
            HTML += '<td>'+nombre+'</td>';
            HTML += '<td>'+apellido+'</td>';
            HTML += '<td>'+datos[i].USUARIO+'</td>';
            HTML += '<td>'+datos[i].PPERFIL+'</td>';
            var idempleado = datos[i].ID_EMPLEADO;
            var empleado = $.trim(nombre)+' '+$.trim(apellido);
            HTML = HTML + '<td><a style="margin-right:4px" href="javascript:void(0)" onclick="sel_empleado(\'' + idempleado + '\',\'' + empleado + '\')" class="btn btn-success"><i class="icon-ok icon-white"></i></a>';
            HTML = HTML + '</td>';
            HTML = HTML + '</tr>';
        }
        HTML = HTML + '</tbody></table>';
        $("#grillaEmpleado").html(HTML);
        $("#jsfoot").html('<script src="' + url + 'vista/web/js/scriptgrilla.js"></script>');
    }, 'json');
}

function buscarVenta() {
    $("#grillaInsumo").html('<div class="page-header"><img src="'+url+'lib/img/loading.gif" /></div>');
    $("#grillaVenta").html('<div class="page-header"><img src="'+url+'lib/img/loading.gif" /></div>');
    $("#grillaEmpleado").html('<div class="page-header"><img src="'+url+'lib/img/loading.gif" /></div>');
    $.post(url + 'produccion/buscadorVenta', 'descripcion=' + $("#buscarVenta").val() + '&filtro=' + $("#filtroVenta").val(), function(datos) {
        var HTML = '<table id="table" class="table table-striped table-bordered table-hover sortable">' +
                '<thead>' +
                '<tr>' +
                '<th>Item</th>'+
                '<th>Tipo Comprobante</th>'+
                '<th>Nro Doc.</th>'+
                '<th>Cliente</th>'+
                '<th>Fecha</th>'+
                '<th>Empleado</th>'+
                '<th>Acciones</th>'+
                '</tr>' +
                '</thead>' +
                '<tbody>';

        for (var i = 0; i < datos.length; i++) {
            HTML = HTML + '<tr>';
            HTML = HTML + '<td>'+(i+1)+'</td>';
            HTML = HTML + '<td>'+datos[i].TTIPOCOMPROBANTE+'</td>';
            HTML = HTML + '<td>'+datos[i].NRODOC+'</td>';
            var acliente = '';
            if(datos[i].ACLIENTE!=null && datos[i].ACLIENTE!='' && datos[i].ACLIENTE!=' '){
                acliente = datos[i].ACLIENTE;
            }
            HTML = HTML + '<td>'+datos[i].NCLIENTE+' '+acliente+'</td>';
            HTML = HTML + '<td>'+datos[i].FECHAVENTA+'</td>';
            HTML = HTML + '<td>'+datos[i].NEMPLEADO+' '+datos[i].AEMPLEADO+'</td>';
            var idventa = datos[i].ID_VENTA;
            var venta = datos[i].NRODOC;
            HTML = HTML + '<td><a style="margin-right:4px" href="javascript:void(0)" onclick="sel_venta(\'' + idventa + '\',\'' + venta + '\')" class="btn btn-success"><i class="icon-ok icon-white"></i></a>';
            HTML = HTML + '</td>';
            HTML = HTML + '</tr>';
        }
        HTML = HTML + '</tbody></table>';
        $("#grillaVenta").html(HTML);
        $("#jsfoot").html('<script src="' + url + 'vista/web/js/scriptgrilla.js"></script>');
    }, 'json');
}

function sel_insumo(id_i, d, s, pc) {
    $("#cantidadum,#preciounitario").attr('disabled', false);
    getUnidadesInsumo(id_i);
    $("#id_insumo").val(id_i);
    $("#insumo").val(d);
    $("#stockactual").val(s);
    $("#precioub").val(pc);
    $("#cantidadum, #cantidadub").val('');
    $("#preciounitario").val(parseFloat(pc).toFixed(2));
    $('#modalInsumo').modal('hide');
    $("#id_unidadmedida").focus();
}

function sel_empleado(id_e, e) {
    $("#id_empleado").val(id_e);
    $("#empleado").val(e);
    $('#modalEmpleado').modal('hide');
}

function sel_venta(id_v, v) {
    $("#id_venta").val(id_v);
    $("#venta").val(v);
    $('#modalVenta').modal('hide');
}

function getUnidadesInsumo(p_id) {
    $("#id_unidadmedida").html('<option>Cargando...</option>');
    $.post(url + 'insumo/getUnidadesInsumo', 'id_insumo=' + p_id, function(datos) {
        var HTML = '<option value="0">&nbsp;</option>';
        for (var i = 0; i < datos.length; i++) {
            HTML = HTML + "<option value='" + datos[i].ID_UNIDADMEDIDA + "' count='" + datos[i].CANT_UNIDAD + "'>" + datos[i].UUNIDADMEDIDA + "</option>";
        }
        $("#id_unidadmedida").html(HTML).attr('disabled', false);
    }, 'json');
}

function limpiar() {
    $("#id_insumo,#stockactual,#insumo,#cantidadum,#cantidadub,#precioub,#preciounitario,#importe").val('');
    $("#cantidadum,#preciounitario,#id_unidadmedida").attr('disabled', true);
    $("#id_unidadmedida").html('<option value="0">Unid. Med.:</option>');
}

function seleccionaDias(fecha_final) {
    var fecha_inicio = $("#fechaproduccion").val();
    if (fecha_inicio == '') {
        bootbox.alert("Escoja una fecha valida");
        $("#fecha_vencimiento").val('');
        return;
    }
    var dias = getDias($(fecha_final).val(), fecha_inicio);
    if (dias <= 0) {
        bootbox.alert("Escoja una fecha valida");
        $("#fecha_vencimiento").val('');
    }
}