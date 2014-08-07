    $(document).ready(function(){
        $( "#buscar" ).focus();
        function buscar(){
            $.post(url+'cronogcobro/buscador','cadena='+$("#buscar").val()+'&filtro='+$("#filtro").val(),function(datos){
                HTML = '<table id="table" class="table table-striped table-bordered table-hover sortable">'+
                        '<thead>'+
                            '<tr>'+
                            '<th style="display:none"></th>'+
                            '<th>Nro Comprobante</th>'+
                            '<th>Cliente</th>'+
                            '<th>Fecha Venta</th>'+
                            '<th>Total</th>'+
                            '<th>Monto Cobrado</th>'+
                            '<th>Monto Restante</th>'+
                            '<th>Accion</th>'+
                        '</tr>'+
                            '</thead>'+
                            '<tbody>';

                for(var i=0;i<datos.length;i++){
                    HTML += '<tr>';
                    HTML += '<td style="display:none"></td>';
                    HTML += '<td>'+datos[i].NRODOC+'</td>';
                    HTML += '<td>'+datos[i].XCLIENTE;
                    HTML += '</td>';
                    HTML += '<td>'+datos[i].FECHA+'</td>';
                    total = (parseFloat(datos[i].IGV)+1)*(parseFloat(datos[i].SUBTOTAL));
                    HTML += '<td>'+total.toFixed(2)+'</td>';
                    montoc = parseFloat(datos[i].XMONTO_COBRADO);
                    HTML += '<td>'+montoc.toFixed(2)+'</td>';
                    montor = ((parseFloat(datos[i].IGV)+1)*(parseFloat(datos[i].SUBTOTAL))-(parseFloat(datos[i].XMONTO_COBRADO)));
                    HTML += '<td>'+montor.toFixed(2)+'</td>';
                    var cronograma=url+'cronogcobro/cronograma/'+datos[i].ID_VENTA+'/'+((parseFloat(datos[i].IGV)+1)*(parseFloat(datos[i].SUBTOTAL))-(parseFloat(datos[i].XMONTO_COBRADO))); 
                    var amortizar=url+'cronogcobro/amortizar/'+datos[i].ID_VENTA+'/'+((parseFloat(datos[i].IGV)+1)*(parseFloat(datos[i].SUBTOTAL))-(parseFloat(datos[i].XMONTO_COBRADO)));   
                    if(datos[i].ESTADOPAGO != 2){
                    HTML += '<td><a style="margin-right:4px" href="'+cronograma+'" class="btn btn-info btn-minier"><i class="icon-list-alt icon-white"></i> Cronograma</a>';
                    HTML += '<a style="margin-right:4px" href="'+amortizar+'" class="btn btn-success btn-minier"><i class="icon-chevron-down icon-white"></i> Amortizar</a>';
                    if(datos[i].XMONTO_COBRADO != 0){
                        HTML += '<a target="_blank" href="'+url+'reportes/ticket_pago/'+datos[i].ID_VENTA+'" class="btn btn-warning btn-minier"><i class="icon-print icon-white"></i> Imprimir Ticket</a>';
                    }
                    HTML += '</td>';
                    }else{
                         HTML += '<td><a target="_blank" href="javascript:void(0)" onclick="imprimir(\''+datos[i].ID_VENTA+'\',\''+datos[i].TTIPOCOMPROBANTE+'\')" class="btn btn-info btn-minier"><i class="icon-print icon-white"></i> Imprimir</a></td>';
                    }
                    HTML += '</tr>';
                }
                HTML += '</tbody></table>'
                $("#grilla").html(HTML);
                $("#jsfoot").html('<script src="'+url+'vista/web/js/scriptgrilla.js"></script>');
            },'json');
        }
        $("#buscar").keypress(function(event){
           buscar();
        });
        
        $("#btn_buscar").click(function(){
            buscar();
            $("#buscar").focus();
        });
        
    });
    
    function imprimir(idventa, tipo){
               switch (tipo){
                    case 'TICKET FACTURA':
                        setTimeout("window.open('"+url+"cronogcobro/ticket_factura/"+idventa+"')", 0);
                        break;tf_venta
                    case 'TICKET SIMPLE':
                        setTimeout("window.open('"+url+"cronogcobro/ticket_simple/"+idventa+"')", 0);
                        break;
                    default:
                        alert("El tipo de documento no es correcto.");
                        setTimeout("window.close()", 0);
                        break;
                }
}