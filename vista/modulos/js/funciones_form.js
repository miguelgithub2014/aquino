$(function() {    
    $( "#descripcion" ).focus(); 
    $( "#save" ).click(function(){
        bval = true;   
        bval = bval && $("#descripcion").required();
        bval = bval && $("#url").required();
        
        if (bval) 
        {
            $("#frm").submit();
        }
        return false;
    });
});