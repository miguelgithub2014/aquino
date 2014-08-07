$(function() {    
    $( "#descripcion" ).focus(); 
    $( "#save" ).click(function(){
        bval = true;   
        bval = bval && $("#id_almacen").required();
        bval = bval && $("#descripcion").required();
        bval = bval && $("#id_unidadmedida").required();
        
        if (bval) {
            $("#frm").submit();
        }
        return false;
    });
});