$(function() {    
    $( "#id_param" ).focus(); 
    $( "#save" ).click(function(){
        bval = true;   
        bval = bval && $("#id_param").required();
        bval = bval && $("#valor").required();
        bval = bval && $("#descripcion").required();
        
        if (bval) 
        {
            $("#frm").submit();
        }
        return false;
    });
});