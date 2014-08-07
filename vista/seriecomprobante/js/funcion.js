    $(function(){
        $( "#buscar" ).focus();
        
        function buscar(){
            $.post(url+'seriecomprobante/buscador','descripcion='+$("#buscar").val()+'&filtro='+$("#filtro").val(),function(datos){
                HTML = '<table id="table" class="table table-striped table-bordered table-hover sortable">'+
                        '<thead>'+
                            '<tr>'+
                                '<th>Item</th>'+
                                '<th>Tipo Comprobante</th>'+
                                '<th>Serie</th>'+
                                '<th>Correlativo</th>'+
                                '<th>Max. Correl.</th>'+
                                '<th>Acciones</th>'+
                            '</tr>'+
                            '</thead>'+
                            '<tbody>';

                for(var i=0;i<datos.length;i++){
                    HTML = HTML + '<tr>';
                    HTML = HTML + '<td>'+(i+1)+'</td>';
                    HTML = HTML + '<td>'+datos[i].TTIPOCOMPROBANTE+'</td>';
                    HTML = HTML + '<td>'+datos[i].SERIE+'</td>';
                    HTML = HTML + '<td>'+datos[i].CORRELATIVO+'</td>';
                    HTML = HTML + '<td>'+datos[i].MAXCORRELATIVO+'</td>';
                    var editar=url+'seriecomprobante/editar/'+datos[i].ID_SERIECOMPROBANTE; 
                    var eliminar=url+'seriecomprobante/eliminar/'+datos[i].ID_SERIECOMPROBANTE;   
                    HTML = HTML + '<td><a style="margin-right:4px" href="javascript:void(0)" onclick="editar(\''+editar+'\')" class="btn btn-success btn-minier"><i class="icon-pencil icon-white"></i></a>';
                    HTML = HTML + '<a href="javascript:void(0)" onclick="eliminar(\''+eliminar+'\')" class="btn btn-danger btn-minier"><i class="icon-remove icon-white"></i></a>';
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