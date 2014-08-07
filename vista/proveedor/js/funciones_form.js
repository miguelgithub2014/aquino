$(function() {    
    $( "#razonsocial" ).focus(); 
    $( "#save" ).click(function(){
        bval = true;   
        bval = bval && $("#razonsocial").required();
        bval = bval && $("#nombre").required();
        bval = bval && $("#ruc").required();
        if(bval && $("#ruc").val().length!=11){
            bootbox.alert("El ruc debe tener 11 digitos");
            bval = false;
        }
        bval = bval && $("#direccion").required();
        bval = bval && $("#telefmovil").required();
        bval = bval && $("#email").email();
        bval = bval && $("#ciudad").required();
        
        if (bval) 
        {
            $("#frm").submit();
        }
        return false;
    });
});