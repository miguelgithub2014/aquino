/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    $( "#buscar" ).focus();
    function buscar(){
            var HTML='',HTML2='';
            $.post(url+'servicios_web/buscar','cadena='+$("#buscar").val()+'&filtro='+$("#filtro").val(),function(datos){
                HTML = '<table id="table" class="table table-striped table-bordered table-hover sortable">'+
                    '<thead>'+
                        '<tr>'+
                            '<th>Item</th>'+
                            '<th>Titulo</th>'+
                            '<th>Acciones</th>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody>';

                for(var i=0;i<datos.length;i++){
                    HTML += '<tr>';
                    HTML += '<td>'+(i+1)+'</td>';
                    HTML += '<td>'+datos[i].TITULO+'</td>';
                    var editar=url+'servicios_web/editar/'+datos[i].ID; 
                    var eliminar=url+'servicios_web/eliminar/'+datos[i].ID;   
                    HTML += '<td><a style="margin-right:4px" href="#myModal" role="button" data-toggle="modal" onclick="ver(\''+datos[i].ID+'\')" class="btn btn-warning btn-minier"><i class="icon-eye-open icon-white"></i> Ver</a>';
                    HTML += '<a style="margin-right:4px" href="javascript:void(0)" onclick="editar(\''+editar+'\')" class="btn btn-success btn-minier"><i class="icon-pencil icon-white"></i> Editar</a>';
                    HTML += '<a href="javascript:void(0)" onclick="eliminar(\''+eliminar+'\')"class="btn btn-danger btn-minier"><i class="icon-remove icon-white"></i> Eliminar</a>';
                    HTML += '</td>';
                    HTML += '</tr>';
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
            $("#myModalLabel").html('');
            $("#bodymodal").html('<div class="text-center"><img src="'+url+'lib/img/loading.gif" /></div>');
            html='';titulo='';
           $.post(url+'servicios_web/ver','id='+id,function(datos){
                titulo = datos[0].TITULO;
                imagen = datos[0].IMAGEN;
		if(imagen != ''){
		    html += "<div class='text-center'><img src='"+url+"lib/img/servicios/"+imagen.toLowerCase()+"' /></div>";
		}else{
		    html += "<h4>No tiene imagen</h4>";
		}
                $("#myModalLabel").html(titulo);
                $("#bodymodal").html(html);
           },'json');
       }