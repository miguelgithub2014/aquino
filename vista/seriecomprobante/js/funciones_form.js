$(function() {    
    $( "#serie" ).focus(); 
    $( "#save" ).click(function(){
        bval = true;   
        bval = bval && $("#serie").required();
        bval = bval && $("#maxcorrelativo").required();
        bval = bval && $("#id_tipocomprobante").required();
        if (bval) {
            $("#frm").submit();
        }
        return false;
    });
});