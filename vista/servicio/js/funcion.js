
$(function(){
        $( "#buscar" ).focus();
        
        function buscar(){
            $.post(url+'servicio/buscador','descripcion='+$("#buscar").val()+'&filtro='+$("#filtro").val(),function(datos){
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
                    HTML = HTML + '<tr>';
                    HTML = HTML + '<td>'+(i+1)+'</td>';
                    HTML = HTML + '<td>'+datos[i].DESCRIPCION+'</td>';
                    HTML = HTML + '<td>'+datos[i].TTIPOSERVICIO+'</td>';
                    var editar=url+'servicio/editar/'+datos[i].ID_SERVICIO; 
                    var eliminar=url+'servicio/eliminar/'+datos[i].ID_SERVICIO;   
                    HTML = HTML + '<td><a style="margin-right:4px" href="'+url+'servicio/asignarunidades/'+datos[i].ID_SERVICIO+'" title="Asignar Unidad Medida" class="btn btn-info btn-minier"><i class="icon-plus icon-white"></i></a>';
                    HTML = HTML + '<a style="margin-right:4px" href="javascript:void(0)" title="editar" onclick="editar(\''+editar+'\')" class="btn btn-success btn-minier"><i class="icon-pencil icon-white"></i></a>';
                    HTML = HTML + '<a href="javascript:void(0)" title="eliminar" onclick="eliminar(\''+eliminar+'\')" class="btn btn-danger btn-minier"><i class="icon-remove icon-white"></i></a>';
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