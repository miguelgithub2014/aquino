    $(function(){
        $( "#buscar" ).focus();
        function buscar(){
            $.post(url+'movimiento/buscador','descripcion='+$("#buscar").val()+'&filtro='+$("#filtro").val(),function(datos){
                HTML = '<table id="table" class="table table-striped table-bordered table-hover sortable">'+
                        '<thead><tr>'+
                            '<th>Item</th>'+
                            '<th>Concepto</th>'+
                            '<th>Referencia</th>'+
                            '<th>Monto</th>'+
                            '<th>Acciones</th>'+
                        '</tr></thead><tbody>';

                for(var i=0;i<datos.length;i++){
                    HTML += '<tr>';
                    HTML += '<td>'+(i+1)+'</td>';
                    HTML += '<td>'+datos[i].XCONCEPTO+'</td>';
                    HTML += '<td>'+datos[i].REFERENCIA+'</td>';
                    HTML += '<td>'+datos[i].MONTO+'</td>';
                    HTML += '<td><a href="'+url+'movimiento/extornar/'+datos[i].ID_MOVIMIENTO+'" title="extornar" class="btn btn-info btn-minier"><i class="icon-repeat icon-white"></i></a></td>';
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


