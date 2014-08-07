    $(document).ready(function(){
        $( "#buscar" ).focus();
        $("#buscar").keyup(function(event){
           buscar();
        });
        
        $("#btn_buscar").click(function(){
            buscar();
            $("#buscar").focus();
        });
        
        function buscar(){
            $.post(url+'cronogpago/buscador','cadena='+$("#buscar").val()+'&filtro='+$("#filtro").val(),function(datos){
                HTML = '<table id="table" class="table table-striped table-bordered table-hover sortable">'+
                        '<thead>'+
                            '<tr>'+
                            '<th style="display: none"></th>'+
                            '<th>Nro Comprobante</th>'+
                            '<th>Proveedor</th>'+
                            '<th>Fecha Compra</th>'+
                            '<th>Total</th>'+
                            '<th>Monto Pagado</th>'+
                            '<th>Monto Restante</th>'+
                            '<th>Accion</th>'+
                        '</tr>'+
                            '</thead>'+
                            '<tbody>';

                for(var i=0;i<datos.length;i++){
                    HTML += '<tr>';
                    HTML += '<td style="display: none"></td>';
                    HTML += '<td>'+datos[i].NRODOC+'</td>';
                    HTML += '<td>'+datos[i].XPROVEEDOR+'</td>';
                    HTML += '<td>'+datos[i].FECHACOMPRA+'</td>';
                    HTML += '<td>'+(parseFloat(datos[i].IGV)+1)*(parseFloat(datos[i].MONTO))+'</td>';
                    HTML += '<td>'+datos[i].XMONTO_PAGADO+'</td>';
                    HTML += '<td>'+((parseFloat(datos[i].IGV)+1)*(parseFloat(datos[i].MONTO))-(parseFloat(datos[i].XMONTO_PAGADO)))+'</td>';
                    var cronograma=url+'cronogpago/cronograma/'+datos[i].ID_COMPRA+'/'+((parseFloat(datos[i].IGV)+1)*(parseFloat(datos[i].MONTO))-(parseFloat(datos[i].XMONTO_PAGADO))); 
                    var amortizar=url+'cronogpago/amortizar/'+datos[i].ID_COMPRA+'/'+((parseFloat(datos[i].IGV)+1)*(parseFloat(datos[i].MONTO))-(parseFloat(datos[i].XMONTO_PAGADO)));   
                    HTML += '<td><a style="margin-right:4px" href="'+cronograma+'" class="btn btn-info btn-minier"><i class="icon-list-alt icon-white"></i> Cronograma</a>';
                    HTML += '<a href="'+amortizar+'" class="btn btn-success btn-minier"><i class="icon-chevron-down icon-white"></i> Amortizar</a>';
                    HTML += '</td>';
                    HTML += '</tr>';
                }
                HTML += '</tbody></table>'
                $("#grilla").html(HTML);
                $("#jsfoot").html('<script src="'+url+'vista/web/js/scriptgrilla.js"></script>');
            },'json');
        }
    });