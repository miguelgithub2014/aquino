    $(function(){
        $( "#buscar" ).focus();
        
        function buscar(){
            $.post(url+'venta/buscador','descripcion='+$("#buscar").val()+'&filtro='+$("#filtro").val(),function(datos){
                var HTML = '<table id="table" class="table table-striped table-bordered table-hover table-condensed">'+
                        '<thead>'+
                            '<tr>'+
                                '<th>Item</th>'+
                                '<th>Tipo Comprobante</th>'+
                                '<th>Nro Doc.</th>'+
                                '<th>Cliente</th>'+
                                '<th>Fecha</th>'+
                                '<th>Empleado</th>'+
                                '<th>Acciones</th>'+
                            '</tr>'+
                            '</thead>'+
                            '<tbody>';

                for(var i=0;i<datos.length;i++){
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
                    var eliminar=url+'venta/eliminar/'+datos[i].ID_VENTA;   
                    HTML = HTML + '<td>';
                    HTML = HTML + '<a href="#myModal" style="margin-right:4px" role="button" data-toggle="modal" title="ver" onclick="ver(\''+datos[i].ID_VENTA+'\')" class="btn btn-warning btn-minier"><i class="icon-eye-open icon-white"></i></a>';
                    if(datos[i].ESTADOPAGO == 0){
                    HTML = HTML + '<a href="javascript:void(0)" title="eliminar" onclick="eliminar(\''+eliminar+'\')" class="btn btn-danger btn-minier"><i class="icon-remove icon-white"></i></a>';
                    }
                    HTML = HTML + '</td>';
                    HTML = HTML + '</tr>';
                }
                HTML = HTML + '</tbody></table>'
                $("#grilla").html(HTML);
                $("#jsfoot").html('<script src="'+url+'vista/web/js/scriptgrilla.js"></script>');
            },'json');
        }
        $("#buscar").keyup(function(event){
           buscar();
        });
        
        $("#btn_buscar").click(function(){
            buscar();
            $("#buscar").focus();
        });
        
    });
    function ver(id){
        titulo='',html='';
        $("#myModalLabel").html('');
        $("#bodymodal").html('<div class="text-center"><img src="'+url+'lib/img/loading.gif" /></div>');
           $.post(url+'venta/ver','idventa='+id,function(datos){
                titulo += 'Datos de la Venta';
                html+='<table class="table table-striped table-bordered table-hover sortable">';
                html+= '<tr>';
                html+= '<td>Nro.Documento:</td>';
                html+= '<td>'+datos[0]['NRODOC']+'</td>';
                html+= '</tr>';
                html+= '<tr>';
                html+= '<td>Cliente:</td>';
                var cliente = datos[0]['NCLIENTE'];
                if(datos[0]['ACLIENTE'] != '' && datos[0]['ACLIENTE'] != null && datos[0]['ACLIENTE'] != ' '){
                     cliente += ' '+ datos[0]['ACLIENTE'];
                }
                html+= '<td>'+cliente+'</td>';
                html+= '</tr>';
                html+= '<tr>';
                html+= '<td>Fecha de Venta:</td>';
                html+= '<td>'+datos[0]['FECHAVENTA']+'</td>';
                html+= '</tr>';
                html+= '<tr>';
                html+= '<td>Tipo de Pago:</td>';
                html+= '<td>'+datos[0]['TTIPOPAGO']+'</td>';
                html+= '</tr>';
                html+= '<tr>';
                html+= '<td>Importe:</td>';
                html+= '<td>'+datos[0]['SUBTOTAL']+'</td>';
                html+= '</tr>';
                html+= '<tr>';
                html+= '<td>IGV:</td>';
                html+= '<td>'+datos[0]['IGV']+'</td>';
                html+= '</tr>';
                html+= '<tr>';
                html+= '<td>Total:</td>';
                tot = (parseFloat(datos[0]['IGV'])+1)*parseFloat(datos[0]['SUBTOTAL']);
                html+= '<td>'+(tot).toFixed(2)+'</td>';
                html+= '</tr>';
                html+= '</table>';
                html+= '<p>Detalle Venta</p>';
                html+= '<table class="table table-striped table-bordered table-hover sortable">';
                html+= '<tr>';
                html+= '<th>Item</th>';
                html+= '<th>Servicio</th>';
                html+= '<th>Unidad Medida</th>';
                html+= '<th>Cantidad</th>';
                html+= '<th>Precio</th>';
                html+= '<th>Subtotal</th>';
                html+= '</tr>';
                for(var i=0;i<datos.length;i++){
                    html+= '<tr>';
                    html+= '<td>'+(i+1)+'</td>';
                    html+= '<td>'+datos[i]['SSERVICIO']+'</td>';
                    html+= '<td>'+datos[i]['UUM']+'</td>';
                    html+= '<td>'+datos[i]['CANTIDAD']+'</td>';
                    html+= '<td>'+datos[i]['PRECIO']+'</td>';
                    html+= '<td>'+(datos[i]['CANTIDAD']*datos[i]['PRECIO']).toFixed(2)+'</td>';
                    html+= '</tr>';
                }
                html+= '</table>';
                
                $("#myModalLabel").html(titulo);
                $("#bodymodal").html(html);
           },'json');
       }
