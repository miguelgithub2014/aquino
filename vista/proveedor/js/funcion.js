    $(function(){
        $("#buscar").focus();
        function buscar(){
            $.post(url+'proveedor/buscador','cadena='+$("#buscar").val()+'&filtro='+$("#filtro").val(),function(datos){
                HTML = '<table id="table" class="table table-striped table-bordered table-hover sortable">'+
                        '<thead>'+
                            '<tr>'+
                                '<th>Item</th>'+
                                '<th>Razon Social</th>'+
                                '<th>Representante</th>'+
                                '<th>Ruc</th>'+
                                '<th>Telefono</th>'+
                                '<th>Acciones</th>'+
                            '</tr>'+
                            '</thead>'+
                            '<tbody>';

                for(var i=0;i<datos.length;i++){
                    HTML += '<tr>';
                    HTML += '<td>'+(i+1)+'</td>';
                    HTML += '<td>'+datos[i].RAZONSOCIAL+'</td>';
                    HTML += '<td>'+datos[i].NOMBRE+'</td>';
                    HTML += '<td>'+datos[i].RUC+'</td>';
                    HTML += '<td>'+datos[i].TELEFMOVIL+'</td>';
                    var editar=url+'proveedor/editar/'+datos[i].ID_PROVEEDOR; 
                    var eliminar=url+'proveedor/eliminar/'+datos[i].ID_PROVEEDOR;   
                    HTML += '<td><a style="margin-right:4px" href="#myModal" role="button" data-toggle="modal" onclick="ver(\''+datos[i].ID_PROVEEDOR+'\')" class="btn btn-warning btn-minier"><i class="icon-eye-open icon-white"></i></a>';
                    HTML += '<a style="margin-right:4px" href="javascript:void(0)" onclick="editar(\''+editar+'\')" class="btn btn-success btn-minier"><i class="icon-pencil icon-white"></i></a>';
                    HTML += '<a href="javascript:void(0)" onclick="eliminar(\''+eliminar+'\')"class="btn btn-danger btn-minier"><i class="icon-remove icon-white"></i></a>';
                    HTML += '</td>';
                    HTML += '</tr>';
                }
                HTML += '</tbody></table>'
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
            $("#myModalLabel").html('');
            $("#bodymodal").html('<div class="text-center"><img src="'+url+'lib/img/loading.gif" /></div>');
            html='';titulo='';
           $.post(url+'proveedor/ver','id='+id,function(datos){
                titulo= 'Proveedor: '+datos[0]['RAZONSOCIAL'];
                html+='<table class="table table-striped table-bordered table-hover sortable">';
                html+= '<tr>';
                html+= '<td>Representante:</td>';
                html+= '<td>'+datos[0]['NOMBRE']+'</td>';
                html+= '</tr>';
                html+= '<tr>';
                html+= '<td>RUC:</td>';
                html+= '<td>'+datos[0]['RUC']+'</td>';
                html+= '</tr>';
                html+= '<tr>';
                html+= '<td>Direccion:</td>';
                html+= '<td>'+datos[0]['DIRECCION']+'</td>';
                html+= '</tr>';
                if(datos[0]['TELEFMOVIL'] != null && datos[0]['TELEFMOVIL'] != ' ' && datos[0]['TELEFMOVIL'] != ''){
                html+= '<tr>';
                html+= '<td>Telefono:</td>';
                html+= '<td>'+datos[0]['TELEFMOVIL']+'</td>';
                html+= '</tr>';
                }
                html+= '<tr>';
                html+= '<td>Email:</td>';
                html+= '<td>'+datos[0]['EMAIL']+'</td>';
                html+= '</tr>';
                html+= '<tr>';
                html+= '<td>Ciudad:</td>';
                html+= '<td>'+datos[0]['CIUDAD']+'</td>';
                html+= '</tr>';
                html+= '</table>';
                $("#myModalLabel").html(titulo);
                $("#bodymodal").html(html);
           },'json');
       }
