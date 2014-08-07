    $(function(){
        $("#buscar").focus();
        function buscar(){
            $.post(url+'insumo/buscador','cadena='+$("#buscar").val()+'&filtro='+$("#filtro").val(),function(datos){
                HTML = '<table id="table" class="table table-striped table-bordered table-hover sortable">'+
                        '<thead>'+
                            '<tr>'+
                                '<th>Item</th>'+
                                '<th>Insumo</th>'+
                                '<th>Almacen</th>'+
                                '<th>Unid. Med.</th>'+
                                '<th>Stock</th>'+
                                '<th>Prec. Compra</th>'+
                                '<th>Acciones</th>'+
                            '</tr>'+
                            '</thead>'+
                            '<tbody>';

                for(var i=0;i<datos.length;i++){
                    HTML = HTML + '<tr>';
                    HTML = HTML + '<td>'+(i+1)+'</td>';
                    HTML = HTML + '<td>'+datos[i].DESCRIPCION+'</td>';
                    HTML = HTML + '<td>'+datos[i].AALMACEN+'</td>';
                    HTML = HTML + '<td>'+datos[i].UUNIDADMEDIDA+'</td>';
                    HTML = HTML + '<td>'+datos[i].STOCK+'</td>';
                    HTML = HTML + '<td>'+datos[i].PRECIOC+'</td>';
                    var editar=url+'insumo/editar/'+datos[i].ID_INSUMO; 
                    var eliminar=url+'insumo/eliminar/'+datos[i].ID_INSUMO;   
                    HTML = HTML + '<td>';
                    HTML = HTML + '<a style="margin-right:4px" href="'+url+'insumo/asignarunidades/'+datos[i].ID_INSUMO+'" title="Asignar Unidad Medida" class="btn btn-info btn-minier"><i class="icon-plus icon-white"></i></a>';
                    HTML = HTML + '<a style="margin-right:4px" href="javascript:void(0)" title="Editar" onclick="editar(\''+editar+'\')" class="btn btn-success btn-minier"><i class="icon-pencil icon-white"></i></a>';
                    HTML = HTML + '<a href="javascript:void(0)" title="Eliminar" onclick="eliminar(\''+eliminar+'\')"class="btn btn-danger btn-minier"><i class="icon-remove icon-white"></i></a>';
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
