$(function() {    
    $("#descripcion").focus(); 
    if($("#codigo").val()=='' || $("#equivalenteunidad").val()==0){
        $("#cant_unid").attr('readonly',true).val('1');
    }
    $("#equivalenteunidad").change(function(){
        if($(this).val()==0){
            $("#cant_unid").attr('readonly',true).val('1');
        }else{
            $("#cant_unid").attr('readonly',false).val('');
        }
    });
    $( "#save" ).click(function(){
        bval = true;   
        bval = bval && $("#descripcion").required();
        bval = bval && $("#prefijo").required();
        bval = bval && $("#cant_unid").required();
        
        if (bval) 
        {
            $("#frm").submit();
        }
        return false;
    });
});