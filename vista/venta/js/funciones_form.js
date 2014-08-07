$(function() {    
    $( "#fechanac" ).datepicker({yearRange: '-65:-10',dateFormat: 'dd-mm-yy',changeMonth:true,changeYear:true,defaultDate: '1-1-1990'});
    
    $("#tipo_cliente").change(function(){
        if($(this).val()=='NATURAL'){
            $("#frm_cliente_natural").show();
            $("#reg_clientenat").show();
            $("#frm_cliente_juridico").hide();
            $("#reg_clientejur").hide();
        }else{
            $("#frm_cliente_natural").hide();
            $("#reg_clientenat").hide();
            $("#frm_cliente_juridico").show();
            $("#reg_clientejur").show();
        }
    });
    $( "#reg_clientenat" ).click(function(){
        bval = true;        
        bval = bval && $( "#dni" ).required(); 
        bval = bval && $( "#nombre" ).required();   
        bval = bval && $( "#apellidos" ).required();
        bval = bval && $( "#direccion" ).required();
        bval = bval && $( "#email" ).required();
        bval = bval && $( "#fechanac" ).required();
        bval = bval && $( "#profesion" ).required();
        bval = bval && $( "#estado_civil" ).required();
        bval = bval && $( "#provincias" ).required();
        bval = bval && $( "#ciudades" ).required();
        if ( bval ) {
            $("#cliente").val("Cargando...");
            $.post(url+'venta/inserta_cli','nombres='+$("#nombre").val()+
                '&apellidos='+$("#apellidos").val()+'&documento='+$("#dni").val()+
                '&fecha_nacimiento='+$("#fechanac").val()+'&telefono='+$("#telefononat").val()+
                '&email='+$("#email").val()+'&estado_civil='+$("#estado_civil").val()+
                '&profesion='+$("#profesion").val()+'&ubigeo='+$("#ciudades").val()+
                '&direccion='+$("#direccion").val()+'&tipo_cliente='+$("#tipo_cliente").val(),function(datos){
                $("#id_cliente").val(datos.x_idcliente);
                $("#cliente").val($("#nombre").val()+' '+$("#apellidos").val());
                $("#nombre,#apellidos,#dni,#fechanac,#telefononat,#email,#estado_civil,#profesion,#ciudades,#direccion").val(''); 
                $("#aceptacredito").val(0);
                $("#maximocredito").val('200');
            },'json');
            $('#modalNuevoCliente').modal('hide');
        }
        return false;
    });  
    
    $( "#reg_clientejur" ).click(function(){
        bval = true;           
        bval = bval && $( "#ruc" ).required(); 
        bval = bval && $( "#razonsocial" ).required();
        bval = bval && $( "#direccionrs" ).required();
        bval = bval && $( "#provinciasjur" ).required();
        bval = bval && $( "#ciudadesjur" ).required();
        if ( bval ) {
            $("#cliente").val("Cargando...");
            $.post(url+'venta/inserta_cli','nombres='+$("#razonsocial").val()+'&documento='+$("#ruc").val()+
                '&telefono='+$("#telefonors").val()+'&email='+$("#emailrs").val()+
                '&ubigeo='+$("#ciudadesjur").val()+
                '&direccion='+$("#direccionrs").val()+'&tipo_cliente='+$("#tipo_cliente").val(),function(datos){
                $("#id_cliente").val(datos.x_idcliente);
                $("#cliente").val($("#razonsocial").val());
                $("#razonsocial,#ruc,#telefonors,#emailrs,#ciudadesjur,#direccionrs").val(''); 
                $("#aceptacredito").val(0);
                $("#maximocredito").val('200');
            },'json');
            $('#modalNuevoCliente').modal('hide');
        }
        return false;
    }); 
    $("#regiones").change(function(){
        if(!$("#regiones").val()){
            $("#provincias").html('<option>Cargando...</option>');
            $("#ciudades").html('<option>Cargando...</option>');
        }else{
            $("#provincias").html('<option>Cargando...</option>');
            $("#ciudades").html('<option>Cargando...</option>');
            $.post(url+'cliente/get_provincias','idregion='+$("#regiones").val(),function(datos){
            $("#provincias").html('<option></option>');
            $("#ciudades").html('<option></option>');
                for(var i=0;i<datos.length;i++){
                    $("#provincias").append('<option value="'+ datos[i].IDUBIGEO + '">' + datos[i].DESCRIPCION+ '</option>');
                }
            },'json');
        }
    });
    
    $("#regionesjur").change(function(){
        if(!$("#regionesjur").val()){
            $("#provinciasjur").html('<option></option>');
            $("#ciudadesjur").html('<option></option>');
        }else{
            $("#provinciasjur").html('<option>Cargando...</option>');
            $("#ciudadesjur").html('<option>Cargando...</option>');
            $.post(url+'cliente/get_provincias','idregion='+$("#regionesjur").val(),function(datos){
                $("#provinciasjur").html('<option></option>');
                $("#ciudadesjur").html('<option></option>');
                for(var i=0;i<datos.length;i++){
                    $("#provinciasjur").append('<option value="'+ datos[i].IDUBIGEO + '">' + datos[i].DESCRIPCION+ '</option>');
                }
            },'json');
        }
    });
    
    $("#provincias").change(function(){
        if(!$("#provincias").val()){
            $("#ciudades").html('<option></option>');
        }else{
            $("#ciudades").html('<option>Cargando...</option>');
            $.post(url+'cliente/get_ciudades','idprovincia='+$("#provincias").val(),function(datos){
                $("#ciudades").html('<option></option>');
                for(var i=0;i<datos.length;i++){
                    if(i!=0){
                        $("#ciudades").append('<option value="'+ datos[i].IDUBIGEO + '">' + datos[i].DESCRIPCION+ '</option>');
                    }
                }       
            },'json');
        }
    });
    
    $("#provinciasjur").change(function(){
        if(!$("#provinciasjur").val()){
            $("#ciudadesjur").html('<option></option>');
        }else{
            $("#ciudadesjur").html('<option>Cargando...</option>');
            $.post(url+'cliente/get_ciudades','idprovincia='+$("#provinciasjur").val(),function(datos){
                $("#ciudadesjur").html('<option></option>');
                for(var i=0;i<datos.length;i++){
                    if(i!=0){
                        $("#ciudadesjur").append('<option value="'+ datos[i].IDUBIGEO + '">' + datos[i].DESCRIPCION+ '</option>');
                    }
                }       
            },'json');
        }
    });
    
    //valida existencia de cliente
    $("#dni").blur(function(){
        if($(this).val()!='' && $(this).val().length==8){
            $.post(url+'cliente/buscador','cadena='+$("#dni").val()+'&filtro=2',function(datos){
                if(datos.length>0){
                    if(confirm('Ya existe un cliente con este Nro de DNI...\nDesea editar sus datos?')){
                        window.location = url+'cliente/editar/'+datos[0].IDCLIENTE
                    }else{
                        $('#modalNuevoCliente').modal('hide');
                    }
                }   
            },'json');
        }
    });
    
    $("#ruc").blur(function(){
        if($(this).val()!='' && $(this).val().length==11){
            $.post(url+'cliente/buscador','cadena='+$("#ruc").val()+'&filtro=2',function(datos){
                if(datos.length>0){
                    if(confirm('Ya existe un cliente con este Nro de RUC...\nDesea editar sus datos?')){
                        window.location = url+'cliente/editar/'+datos[0].IDCLIENTE
                    }else{
                        $('#modalNuevoCliente').modal('hide');
                    }
                }   
            },'json');
        }
    });
    $("#id_tipopago").change(function(){
        if($(this).val()==2){
            $("#celda_credito").show();
        }else{
            $("#celda_credito").hide();
        }
    });
    $("#id_tipocomprobante").focus();
    $("#id_tipocomprobante").change(function(){
        $.post(url+'venta/getCorrelativo','id_tipocomprobante='+$("#id_tipocomprobante").val(),function(datos){
            $("#nrodoc").val(datos);
        });
    });
    $("#id_unidadmedida").change(function(){
        $("#precio").val('');
        if($(this).val()!=0){
            $.post(url+'servicio/getUnidadMedida','codigo='+$("#id_servicio").val()+'&id_unidadmedida='+$("#id_unidadmedida").val(),function(datos){
                $("#precio").val(datos[0].PRECIOV);
            },'json');
        }
    });
    $("#subtotal,#total,#igv").val('0.00');
    $("#chbx_igv").click(function(){
        if($("#chbx_igv").is(':checked')){
            $.post(url+'venta/getParam','id_param=IGV',function(datos){
                $("#igv").val(datos[0].VALOR);
                setTotal(0, 1);
            },'json');
        }else{
            $("#igv").val('0.00');
        }
        setTotal(0, 1);
    });
    $("input:text[readonly=readonly]").css('cursor','pointer');
    limpiar();
    $("#fechaventa, #fecha_vencimiento").datepicker({dateFormat:'yy-mm-dd',changeMonth:true,changeYear:true});
    $( "#save" ).click(function(){
        bval = true;   
        bval = bval && $("#cliente").required();
        bval = bval && $("#id_tipocomprobante").required();
        bval = bval && $("#id_tipopago").required();
        if(bval && $("#id_tipopago").val()==2){
            bval = bval && $("#fecha_vencimiento").required();
            bval = bval && $("#intervalo_dias").required();
            var aceptacredito = $("#aceptacredito").val();
            if(bval && aceptacredito == '1'){
                var total = parseFloat($("#total").val());
                var maximocredito = parseFloat($("#maximocredito").val());
                if(bval && total > maximocredito){
                    bootbox.alert("No puede otorgarle un crédito mayor de S/. "+maximocredito);
                    bval = false;
                }
            } else{
                bootbox.alert("Límite de crédito superado");
                bval = false;
            }
        }
        if (bval) {
            if( $(".row_tmp").length ) {
                bootbox.confirm("¿Está seguro que desea guardar la venta?", function(result) {
                    if(result){
                        $("#frm").submit();
                    }
                });
            }else{
                bootbox.alert("Agregue los servicios al detalle");
            }
        }
        return false;
    });
    $("#selectServicio").click(function(){
        buscarServicio();
        $("#buscarServicio").focus();
        $("#VtnBuscarServicio").show();
    });
    $("#servicio").click(function(){
        buscarServicio();
        $("#buscarServicio").focus();
        $("#VtnBuscarServicio").show();
        $("#buscarServicio").focus();
    });
    $("#AbrirVtnBuscarServicio").click(function(){
        buscarServicio();
        $("#buscarServicio").focus();
        $("#VtnBuscarServicio").show();
        $("#buscarServicio").focus();
    });
    $("#cliente").click(function(){
        buscarCliente();
        $("#buscarCliente").focus();
        $("#VtnBuscarCliente").show();
        $("#buscarCliente").focus();
    });
    $("#AbrirVtnBuscarCliente").click(function(){
        buscarCliente();
        $("#buscarCliente").focus();
        $("#VtnBuscarCliente").show();
        $("#buscarCliente").focus();
    });
    $("#buscarServicio").keypress(function(event){
        if(event.which == 13){
            event.preventDefault();
            buscarServicio();
        } 
    });
    $("#btn_buscarServicio").click(function(){
        buscarServicio();
        $("#buscarServicio").focus();
    });
    $("#buscarCliente").keypress(function(event){
        if(event.which == 13){
            event.preventDefault();
            buscarCliente();
        } 
    });
    $("#btn_buscarCliente").click(function(){
        buscarCliente();
        $("#buscarCliente").focus();
    });
    $("#cantidad").keyup(function(){
        setImporte();
    });
    $("#precio").keyup(function(){
        setImporte();
    });
    $("#precio").blur(function(){
        var precio = parseFloat($(this).val());
        if (isNaN(precio)) {
            precio = 0;
        }
        $(this).val(precio.toFixed(2));
    });
    
    $("#addDetalle").click(function(){
        bval = true;   
        bval = bval && $("#servicio").required();
        bval = bval && $("#id_unidadmedida").required();
        bval = bval && $("#cantidad").required();
        bval = bval && $("#precio").required();
        if (bval) {
            if( $(".id_serv[value="+$("#id_servicio").val()+"]").length ) {
                bootbox.alert("Este servicio ya fue agregado");
                return false;
            }
            var html = '<tr class="row_tmp">';
            html += '<td>';
            html += '   <input type="hidden" name="id_servicio[]" class="id_serv" value="' + $("#id_servicio").val() + '" />'+$("#servicio").val();
            html += '</td>';
            html += '<td>';
            html += '   <input type="hidden" name="id_unidadmedida[]" value="' + $("#id_unidadmedida").val() + '" />'+$("#id_unidadmedida option:selected").html();
            html += '</td>';
            html += '<td>';
            html += '   <input type="hidden" name="cantidad[]" value="' + $("#cantidad").val() + '" />'+$("#cantidad").val();
            html += '</td>';
            html += '<td>';
            html += '   <input type="hidden" name="precio[]" value="' + $("#precio").val() + '" />'+$("#precio").val();
            html += '</td>';
            html += '<td>';
            html += '   <input type="hidden" name="importe[]" class="importe" value="' + $("#importe").val() + '" />'+$("#importe").val();
            html += '</td>';
            html += '<td>';
            html += '   <a class="btn btn-danger delete"><i class="icon-trash icon-white"></i></a>';
            html += '</td>';
            html += '</tr>';

            $("#tblDetalle").append(html);
            setTotal($("#importe").val(),1);
            limpiar();
        }
    });
    
    $(".delete").live('click',function(){
        var i = $(this).parent().parent().index();
        var importe = $("#tblDetalle tr:eq("+i+") td .importe").val();
        $("#tblDetalle tr:eq("+i+")").remove();
        setTotal(importe,0);
    });
});

function setImporte(){
    var cantidad = $("#cantidad").val();
    cantidad = parseInt(cantidad);
    if (isNaN(cantidad)) {
        cantidad = 0;
    }
    var precio = $("#precio").val();
    precio = parseFloat(precio);
    if (isNaN(precio)) {
        precio = 0;
    }
    var importe;
    importe = cantidad * precio;
    $("#importe").val(importe.toFixed(2));
}

function setTotal(importe,aumenta){
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
    if(aumenta){
        subtotal = subtotal + parseFloat(importe);
    }else{
        subtotal = subtotal - parseFloat(importe);
    }
    $("#subtotal").val(subtotal.toFixed(2));
    var total = subtotal + subtotal * igv;
    $("#total").val(total.toFixed(2));
}
function buscarServicio(){
    $("#grillaServicio").html('<div class="page-header"><img src="'+url+'lib/img/loading.gif" /></div>');
    $("#grillaCliente").html('<div class="page-header"><img src="'+url+'lib/img/loading.gif" /></div>');
    $("#modalServicio").modal('show');
    $.post(url+'servicio/buscador','descripcion='+$("#buscarServicio").val()+'&filtro='+$("#filtroServicio").val(),function(datos){
        HTML = '<table id="table" class="table table-striped table-bordered table-hover sortable">'+
        '<thead>'+
        '<tr>'+
        '<th>Item</th>'+
        '<th>Descripcion</th>'+
        '<th>Tipo Servicio</th>'+
        '<th>Acciones</th>'+
        '</tr>'+
        '</thead>'+
        '<tbody>';

        for(var i=0;i<datos.length;i++){
            var idservicio = datos[i].ID_SERVICIO;
            var descripcion = datos[i].DESCRIPCION;
            HTML = HTML + '<tr>';
            HTML = HTML + '<td>'+(i+1)+'</td>';
            HTML = HTML + '<td>'+descripcion+'</td>';
            HTML = HTML + '<td>'+datos[i].TTIPOSERVICIO+'</td>';
            HTML = HTML + '<td><a style="margin-right:4px" href="javascript:void(0)" onclick="sel_servicio(\''+idservicio+'\',\''+descripcion+'\')" class="btn btn-success btn-minier"><i class="icon-ok icon-white"></i> </a>';
            HTML = HTML + '</td>';
            HTML = HTML + '</tr>';
        }
        HTML = HTML + '</tbody></table>';
        $("#grillaServicio").html(HTML);
        $("#jsfoot").html('<script src="'+url+'vista/web/js/scriptgrilla.js"></script>');
    },'json');
}

function buscarCliente(){
    $("#grillaServicio").html('<div class="page-header"><img src="'+url+'lib/img/loading.gif" /></div>');
    $("#grillaCliente").html('<div class="page-header"><img src="'+url+'lib/img/loading.gif" /></div>');
    $.post(url+'cliente/buscador','cadena='+$("#buscarCliente").val()+'&filtro='+$("#filtroCliente").val(),function(datos){
        HTML = '<table id="table" class="table table-striped table-bordered table-hover sortable">'+
        '<thead>'+
        '<tr>'+
        '<th>Item</th>'+
        '<th>Tipo</th>'+
        '<th>Nombre y Apellidos / Razon Social</th>'+
        '<th>DNI / RUC</th>'+
        '<th>Direccion</th>'+
        '<th>Acciones</th>'+
        '</tr>'+
        '</thead>'+
        '<tbody>';

        for(var i=0;i<datos.length;i++){
            var cliente = $.trim(datos[i].NOMBRES);
            if(datos[i].APELLIDOS!=null){
                cliente += ' '+datos[i].APELLIDOS;
            }
            HTML = HTML + '<tr>';
            HTML = HTML + '<td>'+(i+1)+'</td>';
            HTML = HTML + '<td>'+datos[i].TIPO+'</td>';
            HTML = HTML + '<td>'+cliente+'</td>';
            HTML = HTML + '<td>'+datos[i].DOCUMENTO+'</td>';
            HTML = HTML + '<td>'+datos[i].DIRECCION+'</td>';
            var idcliente = datos[i].IDCLIENTE;
            var maximocredito = datos[i].MAXIMOCREDITO;
            HTML = HTML + '<td><a style="margin-right:4px" href="javascript:void(0)" onclick="sel_cliente(\''+idcliente+'\',\''+cliente+'\',\''+maximocredito+'\')" class="btn btn-success btn-minier"><i class="icon-ok icon-white"></i> </a>';
            HTML = HTML + '</td>';
            HTML = HTML + '</tr>';
        }
        HTML = HTML + '</tbody></table>'
        $("#grillaCliente").html(HTML);
        $("#jsfoot").html('<script src="'+url+'vista/web/js/scriptgrilla.js"></script>');
    },'json');
}

function sel_servicio(id_s,s){
    getUnidadesServicio(id_s);
    $("#cantidad, #precio").val('');
    $("#cantidad, #precio").attr('disabled',false);
    $("#id_servicio").val(id_s);
    $("#servicio").val(s);
    $('#modalServicio').modal('hide');
    $("#cantidad").focus();
}

function getUnidadesServicio(s_id) {
    $("#id_unidadmedida").html('<option>Cargando...</option>');
    $.post(url + 'servicio/getUnidadesServicio', 'id_servicio=' + s_id, function(datos) {
        var HTML = '';
        HTML = HTML + "<option value='0' >&nbsp;</option>";
        for (var i = 0; i < datos.length; i++) {
            HTML = HTML + "<option value='" + datos[i].ID_UNIDADMEDIDA + "' count='" + datos[i].CANT_UNIDAD + "'>" + datos[i].UUNIDADMEDIDA + "</option>";
        }
        $("#id_unidadmedida").html(HTML).attr('disabled', false);
    }, 'json');
}

function sel_cliente(id_p,d, maximocredito){
    $.post(url+'cliente/getCreditoCliente','idcliente='+id_p,function(datos){
        if(datos.estadopago==2){
            $("#aceptacredito").val(1);
        }else{
            $("#aceptacredito").val(0);
        }
    },'json');
    $("#id_cliente").val(id_p);
    $("#cliente").val(d);
    $("#maximocredito").val(maximocredito);
    $('#modalCliente').modal('hide');
    $("#id_tipopago").focus();
}

function limpiar(){
    $("#id_servicio,#servicio,#cantidad,#cantidadub,#precio,#importe").val('');
    $("#cantidad,#precio").attr('disabled',true);
    $("#id_unidadmedida").html('<option value="0">Unid. Med.:</option>');
}

function seleccionaDias(fecha_final) {
    var dias = getDias($(fecha_final).val(),$("#fecha_inicial").val());
    if (dias <= 0) {
        bootbox.alert("Escoja una fecha valida");
        $("#fecha_vencimiento").val('');
    }
}