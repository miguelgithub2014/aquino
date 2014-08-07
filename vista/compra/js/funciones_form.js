$(function() {
    $("#id_tipopago").change(function() {
        if ($(this).val() == 2) {
            $("#celda_credito").show();
        } else {
            $("#celda_credito").hide();
        }
    });
    $("#nrodoc").focus();
    $("#subtotal,#total,#igv").val('0.00');
    $("#chbx_igv").click(function() {
        if ($("#chbx_igv").is(':checked')) {
            $.post(url + 'compra/getParam', 'id_param=IGV', function(datos) {
                $("#igv").val(datos[0].VALOR);
                setTotal(0, 1);
            }, 'json');
        } else {
            $("#igv").val('0.00');
        }
        setTotal(0, 1);
    });
    $("input:text[readonly=readonly]").css('cursor', 'pointer');
    limpiar();
    $("#fechacompra, #fecha_vencimiento").datepicker({dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true});
    $("#save").click(function() {
        bval = true;
        bval = bval && $("#nrodoc").required();
        bval = bval && $("#fechacompra").required();
        bval = bval && $("#proveedor").required();
        bval = bval && $("#id_tipopago").required();
        if ($("#id_tipopago").val() == 2) {
            bval = bval && $("#fecha_vencimiento").required();
            bval = bval && $("#intervalo_dias").required();
        }
        if (bval) {
            if ($(".row_tmp").length) {
                bootbox.confirm("¿Está seguro que desea guardar la compra?", function(result) {
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
    $("#proveedor").click(function() {
        buscarProveedor();
        $("#buscarProveedor").focus();
        $("#VtnBuscarProveedor").show();
        $("#buscarProveedor").focus();
    });
    $("#proveedor").focus(function() {
        buscarProveedor();
        $("#buscarProveedor").focus();
        $("#VtnBuscarProveedor").show();
        $("#buscarProveedor").focus();
    });
    $("#AbrirVtnBuscarProveedor").click(function() {
        buscarProveedor();
        $("#buscarProveedor").focus();
        $("#VtnBuscarProveedor").show();
        $("#buscarProveedor").focus();
    });

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

    $("#buscarProveedor").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            buscarProveedor();
        }
    });

    $("#btn_buscarProveedor").click(function() {
        buscarProveedor();
        $("#buscarProveedor").focus();
    });

    $("#cantidadum").keyup(function() {
        setImporte();
    });
    $("#id_unidadmedida").change(function() {
        setImporte();
        var precioub = parseFloat($("#precioub").val());
        var cantidadub = parseInt($("#id_unidadmedida option:selected").attr('count'));
        var preciounitario = cantidadub * precioub;
        preciounitario = Math.round(preciounitario * 100) / 100;
        $("#preciounitario").val(preciounitario.toFixed(2));
        setImporte();
    });
    $("#preciounitario").keyup(function() {
        setImporte();
        var preciounitario = $("#preciounitario").val();
        preciounitario = parseFloat(preciounitario);
        if (isNaN(preciounitario)) {
            preciounitario = 0;
        }
        var cantidadub = $("#id_unidadmedida option:selected").attr('count');
        cantidadub = parseInt(cantidadub);
        if (isNaN(cantidadub)) {
            cantidadub = 0;
        }
        var precioub = preciounitario / cantidadub;
        $("#precioub").val(precioub.toFixed(6));
    });
    $("#preciounitario").blur(function() {
        var preciounitario = parseFloat($(this).val());
        if (isNaN(preciounitario)) {
            preciounitario = 0;
        }
        $(this).val(preciounitario.toFixed(2));
    });

    $("#addDetalle").click(function() {
        bval = true;
        bval = bval && $("#insumo").required();
        bval = bval && $("#id_unidadmedida").required();
        bval = bval && $("#cantidadum").required();
        bval = bval && $("#preciounitario").required();

        if (bval) {
            if ($(".id_prod[value=" + $("#id_insumo").val() + "]").length) {
                bootbox.alert("Este insumo ya fue agregado");
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
            html += '   <input type="hidden" name="stockactual[]" value="' + $("#stockactual").val() + '" />';
            html += '   <input type="hidden" name="cantidadub[]" value="' + $("#cantidadub").val() + '" />';
            html += '</td>';
            html += '<td>';
            html += '   <input type="hidden" name="precioub[]" value="' + $("#precioub").val() + '" />';
            html += '   <input type="hidden" name="preciounitario[]" value="' + $("#preciounitario").val() + '" />' + $("#preciounitario").val();
            html += '</td>';
            html += '<td>';
            html += '   <input type="hidden" name="importe[]" class="importe" value="' + $("#importe").val() + '" />' + $("#importe").val();
            html += '</td>';
            html += '<td>';
            html += '   <a class="btn btn-danger delete"><i class="icon-trash icon-white"></i></a>';
            html += '</td>';
            html += '</tr>';

            $("#tblDetalle").append(html);
            setTotal($("#importe").val(), 1);
            limpiar();
        }
    });

    $(".delete").live('click', function() {
        var i = $(this).parent().parent().index();
        var importe = $("#tblDetalle tr:eq(" + i + ") td .importe").val();
        $("#tblDetalle tr:eq(" + i + ")").remove();
        setTotal(importe, 0);
    });
    $("#reg_proveedor").click(function() {
        rs = $("#razonsocialprov").val();
        prov = $("#nombreprov").val();
        ruc = $("#rucprov").val();
        dir = $("#direccionprov").val();
        tel = $("#telefmovilprov").val();
        email = $("#emailprov").val();
        ciu = $("#ciudadprov").val();
        if (rs == "") {
            alert("Ingrese Razon Social");
            $("#razonsocialprov").focus();
        }
        else {
            if (prov == "") {
                alert("Ingrese Representante");
                $("#nombreprov").focus();
            }
            else {
                if (ruc == "") {
                    alert("Ingrese Ruc");
                    $("#rucprov").focus();
                }
                else {
                    if (dir == "") {
                        alert("Ingrese Direccion");
                        $("#direccionprov").focus();
                    }
                    else {
                        if (tel == "") {
                            alert("Ingrese Telefono");
                            $("#telefmovilprov").focus();
                        }
                        else {
                            if (email == "") {
                                alert("Ingrese Email");
                                $("#emailprov").focus();
                            }
                            else {
                                if (ciu == "") {
                                    alert("Ingrese Ciudad");
                                    $("#ciudadprov").focus();
                                }
                                else {
                                    $.post(url + 'compra/inserta_prov', 'nombre=' + $("#nombreprov").val() + '&dir=' + $("#direccionprov").val() + '&rs=' + $("#razonsocialprov").val() +
                                            '&em=' + $("#emailprov").val() + '&ciu=' + $("#ciudadprov").val() + '&ruc=' + $("#rucprov").val() + '&tel=' + $("#telefmovilprov").val(), function(datos) {
                                        $("#id_proveedor").val(datos.id_proveedor);
                                        $("#proveedor").val($("#razonsocialprov").val());
                                        $('#modalNuevoProveedor').modal('hide');
                                        $("#razonsocialprov,#nombreprov,#rucprov,#direccionprov,#telefmovilprov,#emailprov,#ciudadprov").val('');
                                    }, 'json')
                                }
                            }
                        }
                    }
                }
            }
        }
    });
});

function setImporte() {
    var cantidad = $("#cantidadum").val();
    cantidad = parseInt(cantidad);
    if (isNaN(cantidad)) {
        cantidad = 0;
    }
    var cantidadub = cantidad * parseInt($("#id_unidadmedida option:selected").attr('count'));
    $("#cantidadub").val(cantidadub);
    var precio = $("#preciounitario").val();
    precio = parseFloat(precio);
    if (isNaN(precio)) {
        precio = 0;
    }
    var importe;
    importe = cantidad * precio;
    $("#importe").val(importe.toFixed(2));
}

function setTotal(importe, aumenta) {
    var subtotal = $("#subtotal").val();
    subtotal = parseFloat(subtotal);
    if (isNaN(subtotal)) {
        subtotal = 0;
    }
    var igv = $("#igv").val();
    igv = parseFloat(igv);
    if (isNaN(igv)) {
        igv = 0;
    }
    if (aumenta) {
        subtotal = subtotal + parseFloat(importe);
    } else {
        subtotal = subtotal - parseFloat(importe);
    }
    $("#subtotal").val(subtotal.toFixed(2));
    var total = subtotal + subtotal * igv;
    $("#total").val(total.toFixed(2));
}
function buscarInsumo() {
    $("#grillaInsumo").html('<div class="page-header"><img src="'+url+'lib/img/loading.gif" /></div>');
    $("#grillaProveedor").html('<div class="page-header"><img src="'+url+'lib/img/loading.gif" /></div>');
    $.post(url + 'insumo/buscador', 'cadena=' + $("#buscarInsumo").val() + '&filtro=' + $("#filtroInsumo").val(), function(datos) {
        var HTML = '<table id="table" class="table table-striped table-bordered table-hover sortable">' +
                '<thead>' +
                '<tr>' +
                '<th>Item</th>'+
                '<th>Insumo</th>'+
                '<th>Almacen</th>'+
                '<th>Unid. Med.</th>'+
                '<th>Stock</th>'+
                '<th>Prec. Compra</th>'+
                '<th>Acciones</th>'+
                '</tr>' +
                '</thead>' +
                '<tbody>';

        for (var i = 0; i < datos.length; i++) {
            HTML = HTML + '<tr>';
            HTML = HTML + '<td>'+(i+1)+'</td>';
            HTML = HTML + '<td>'+datos[i].DESCRIPCION+'</td>';
            HTML = HTML + '<td>'+datos[i].AALMACEN+'</td>';
            HTML = HTML + '<td>'+datos[i].UUNIDADMEDIDA+'</td>';
            HTML = HTML + '<td>'+datos[i].STOCK+'</td>';
            HTML = HTML + '<td>'+datos[i].PRECIOC+'</td>';
            var idinsumo = datos[i].ID_INSUMO;
            var descripcion = datos[i].DESCRIPCION;
            var stock = datos[i].STOCK;
            var precioc = datos[i].PRECIOC;
            HTML = HTML + '<td><a style="margin-right:4px" href="javascript:void(0)" onclick="sel_insumo(\'' + idinsumo + '\',\'' + descripcion + '\',\'' + stock + '\',\'' + precioc + '\')" class="btn btn-success"><i class="icon-ok icon-white"></i> </a>';
            HTML = HTML + '</td>';
            HTML = HTML + '</tr>';
        }
        HTML = HTML + '</tbody></table>'
        $("#grillaInsumo").html(HTML);
        $("#jsfoot").html('<script src="' + url + 'vista/web/js/scriptgrilla.js"></script>');
    }, 'json');
}

function buscarProveedor() {
    $("#grillaInsumo").html('<div class="page-header"><img src="'+url+'lib/img/loading.gif" /></div>');
    $("#grillaProveedor").html('<div class="page-header"><img src="'+url+'lib/img/loading.gif" /></div>');
    $.post(url + 'proveedor/buscador', 'cadena=' + $("#buscarProveedor").val() + '&filtro=' + $("#filtroProveedor").val(), function(datos) {
        var HTML = '<table id="table" class="table table-striped table-bordered table-hover sortable">' +
                '<thead>' +
                '<tr>' +
                '<th>Item</th>' +
                '<th>Razon Social</th>' +
                '<th>Representante</th>' +
                '<th>Ruc</th>' +
                '<th>Telefono</th>' +
                '<th>Acciones</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>';

        for (var i = 0; i < datos.length; i++) {
            HTML = HTML + '<tr>';
            HTML = HTML + '<td>' + (i + 1) + '</td>';
            HTML = HTML + '<td>' + datos[i].RAZONSOCIAL + '</td>';
            HTML = HTML + '<td>' + datos[i].NOMBRE + '</td>';
            HTML = HTML + '<td>' + datos[i].RUC + '</td>';
            HTML = HTML + '<td>' + datos[i].TELEFMOVIL + '</td>';
            var idproveedor = datos[i].ID_PROVEEDOR;
            var descripcion = $.trim(datos[i].RAZONSOCIAL);
            HTML = HTML + '<td><a style="margin-right:4px" href="javascript:void(0)" onclick="sel_proveedor(\'' + idproveedor + '\',\'' + descripcion + '\')" class="btn btn-success"><i class="icon-ok icon-white"></i> </a>';
            HTML = HTML + '</td>';
            HTML = HTML + '</tr>';
        }
        HTML = HTML + '</tbody></table>';
        $("#grillaProveedor").html(HTML);
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
    $("#preciounitario").val(parseFloat(pc).toFixed(2));
    $('#modalInsumo').modal('hide');
    $("#id_unidadmedida").focus();
}

function sel_proveedor(id_p, d) {
    $("#id_proveedor").val(id_p);
    $("#proveedor").val(d);
    $('#modalProveedor').modal('hide');
    $("#id_tipopago").focus();
}

function getUnidadesInsumo(p_id) {
    $("#id_unidadmedida").html('<option>Cargando...</option>');
    $.post(url + 'compra/getUnidadesInsumo', 'id_insumo=' + p_id, function(datos) {
        var HTML = '';
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
    fecha_inicio = $("#fechacompra").val();
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