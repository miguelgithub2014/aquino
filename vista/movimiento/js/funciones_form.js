$(function() {    
    $("#id_tipoconcepto").focus();   
    $("#id_tipoconcepto").change(function(){
        if($(this).val()==1){
            $("#celda_formapago").show();
        }else{
            $("#celda_formapago").hide();
        }
        $("#concepto").html('<option value="0">Cargando...</option>');
        var HTML = '<option value="0"></option>';
        if($(this).val()!=0){
            $.post(url+'concepto/buscador','descripcion='+$("#id_tipoconcepto option:selected").html()+'&filtro=1',function(datos){
                for(var i=0;i<datos.length;i++){
                    HTML += '<option value="'+datos[i].ID_CONCEPTO+'">'+datos[i].DESCRIPCION+'</option>';
                }
                $("#concepto").html(HTML);
            },'json');
        }else{
            $("#concepto").html(HTML);
        }
    });
    $( "#save" ).click(function(){
        bval = true;   
        bval = bval && $("#id_tipoconcepto").required();
        bval = bval && $("#concepto").required();
        bval = bval && $("#referencia").required();
        if($("#id_tipoconcepto").val()==1){
            bval = bval && $("#id_formapago").required();
        }
        bval = bval && $("#monto").required();
        
        if (bval) 
        {
            $("#frm").submit();
        }
        return false;
    }); 
});