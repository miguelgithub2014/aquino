    $(function(){
        $("#buscar").focus();
        function buscar(){
            $.post(url+'modulos/buscador','cadena='+$("#buscar").val()+'&filtro='+$("#filtro").val(),function(datos){
                HTML = '<table id="table" class="table table-striped table-bordered table-hover sortable">'+
                        '<thead>'+
                            '<tr>'+
                                '<th>Item</th>'+
                                '<th>Descripcion</th>'+
                                '<th>Icono</th>'+
                                '<th>Url</th>'+
                                '<th>Modulo Padre</th>'+
                                '<th>Acciones</th>'+
                            '</tr>'+
                            '</thead>'+
                            '<tbody>';

                for(var i=0;i<datos.length;i++){
                    HTML = HTML + '<tr>';
                    HTML = HTML + '<td>'+(i+1)+'</td>';
                    HTML = HTML + '<td>'+datos[i].DESCRIPCION+'</td>';
                    HTML = HTML + '<td>'+datos[i].ICONO+'</td>';
                    HTML = HTML + '<td>'+datos[i].URL+'</td>';
                    if(datos[i].MODULO_PADRE != null){
                        HTML = HTML + '<td>'+datos[i].MODULO_PADRE+'</td>';
                    }else{
                        HTML = HTML + '<td>&nbsp;</td>';
                    }
                    var editar=url+'modulos/editar/'+datos[i].IDMODULO; 
                    var eliminar=url+'modulos/eliminar/'+datos[i].IDMODULO;   
                    HTML = HTML + '<td><a style="margin-right:4px" href="javascript:void(0)" onclick="editar(\''+editar+'\')" class="btn btn-success btn-minier"><i class="icon-pencil icon-white"></i></a>';
                    HTML = HTML + '<a href="javascript:void(0)" onclick="eliminar(\''+eliminar+'\')"class="btn btn-danger btn-minier"><i class="icon-remove icon-white"></i></a>';
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