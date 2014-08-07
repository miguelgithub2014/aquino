$(function() {    
    $( "#descripcion" ).focus(); 
    $( "#save" ).click(function(){
        bval = true;   
        bval = bval && $("#descripcion").required();
        bval = bval && $("#id_tipoconcepto").required();
        
        if (bval) 
        {
            $("#frm").submit();
        }
        return false;
    });
});