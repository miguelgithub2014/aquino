$(document).ready(function(){
    $("#tipo_cliente").focus();
    $( "#fechanac" ).datepicker({yearRange: '-65:-10',dateFormat: 'dd-mm-yy',changeMonth:true,changeYear:true,defaultDate: '1-1-1990'});
    $( "#saveformnatural" ).click(function(){
        bval = true;        
        bval = bval && $( "#nrodoc" ).required(); 
        if(bval && $("#nrodoc").val().length!=8){
            bootbox.alert("El nro de documento debe tener 8 digitos");
            bval = false;
        }
        bval = bval && $( "#nombre" ).required();   
        bval = bval && $( "#apellidos" ).required();
        bval = bval && $( "#direccion" ).required();
        bval = bval && $( "#email" ).email();
        bval = bval && $( "#fechanac" ).required();
        bval = bval && $( "#profesion" ).required();
        bval = bval && $( "#estado_civil" ).required();
        bval = bval && $( "#provincias" ).required();
        bval = bval && $( "#ciudades" ).required();
        if ( bval ) {
            $("#frm_natural").submit();
        }
        return false;
    });  
    
    $( "#saveformjuridico" ).click(function(){
        bval = true;           
        bval = bval && $( "#ruc" ).required(); 
        if(bval && $("#ruc").val().length!=11){
            bootbox.alert("El ruc debe tener 11 digitos");
            bval = false;
        }
        bval = bval && $( "#razonsocial" ).required();
        bval = bval && $( "#direccionrs" ).required();
        bval = bval && $( "#provinciasjur" ).required();
        bval = bval && $( "#ciudadesjur" ).required();
        if ( bval ) {
            $("#frm_juridico").submit();
        }
        return false;
    }); 
    $("#tipo_cliente").change(function(){
        if($(this).val()=='NATURAL'){
            $("#frm_cliente_natural").show();
            $("#frm_cliente_juridico").hide();
        }else{
            $("#frm_cliente_natural").hide();
            $("#frm_cliente_juridico").show();
        }
    });
    
    $("#regiones").change(function(){
        if(!$("#regiones").val()){
            $("#provincias").html('<option>Cargando...</option>');
            $("#ciudades").html('<option>Cargando...</option>');
        }else{
            $("#provincias").html('<option>Cargando...</option>');
            $("#ciudades").html('<option>Cargando...</option>');
            $.post(url+'cliente/get_provincias','idregion='+$("#regiones").val(),function(datos){
            $("#provincias").html('<option></option>');
            $("#ciudades").html('<option></option>');
                for(var i=0;i<datos.length;i++){
                    $("#provincias").append('<option value="'+ datos[i].IDUBIGEO + '">' + datos[i].DESCRIPCION+ '</option>');
                }
            },'json');
        }
    });
    
    $("#regionesjur").change(function(){
        if(!$("#regionesjur").val()){
            $("#provinciasjur").html('<option></option>');
            $("#ciudadesjur").html('<option></option>');
        }else{
            $("#provinciasjur").html('<option>Cargando...</option>');
            $("#ciudadesjur").html('<option>Cargando...</option>');
            $.post(url+'cliente/get_provincias','idregion='+$("#regionesjur").val(),function(datos){
                $("#provinciasjur").html('<option></option>');
                $("#ciudadesjur").html('<option></option>');
                for(var i=0;i<datos.length;i++){
                    $("#provinciasjur").append('<option value="'+ datos[i].IDUBIGEO + '">' + datos[i].DESCRIPCION+ '</option>');
                }
            },'json');
        }
    });
    
    $("#provincias").change(function(){
        if(!$("#provincias").val()){
            $("#ciudades").html('<option></option>');
        }else{
            $("#ciudades").html('<option>Cargando...</option>');
            $.post(url+'cliente/get_ciudades','idprovincia='+$("#provincias").val(),function(datos){
                $("#ciudades").html('<option></option>');
                for(var i=0;i<datos.length;i++){
                    if(i!=0){
                        $("#ciudades").append('<option value="'+ datos[i].IDUBIGEO + '">' + datos[i].DESCRIPCION+ '</option>');
                    }
                }       
            },'json');
        }
    });
    
    $("#provinciasjur").change(function(){
        if(!$("#provinciasjur").val()){
            $("#ciudadesjur").html('<option></option>');
        }else{
            $("#ciudadesjur").html('<option>Cargando...</option>');
            $.post(url+'cliente/get_ciudades','idprovincia='+$("#provinciasjur").val(),function(datos){
                $("#ciudadesjur").html('<option></option>');
                for(var i=0;i<datos.length;i++){
                    if(i!=0){
                        $("#ciudadesjur").append('<option value="'+ datos[i].IDUBIGEO + '">' + datos[i].DESCRIPCION+ '</option>');
                    }
                }       
            },'json');
        }
    });
    
    //valida existencia de cliente
    $("#nrodoc").blur(function(){
        if($(this).val()!='' && $(this).val().length==8){
            $.post(url+'cliente/buscador','cadena='+$("#nrodoc").val()+'&filtro=2',function(datos){

                if(datos.length>0){
                    if(confirm('Ya existe un cliente con este Nro de DNI...\nDesea editar sus datos?')){
                        window.location = url+'cliente/editar/'+datos[0].IDCLIENTE
                    }else{
                        window.location = url+'cliente/';
                    }
                }   
            },'json');
        }
    });
    
    $("#ruc").blur(function(){
        if($(this).val()!='' && $(this).val().length==11){
            $.post(url+'cliente/buscador','cadena='+$("#ruc").val()+'&filtro=2',function(datos){

                if(datos.length>0){
                    if(confirm('Ya existe un cliente con este Nro de RUC...\nDesea editar sus datos?')){
                        window.location = url+'cliente/editar/'+datos[0].IDCLIENTE
                    }else{
                        window.location = url+'cliente/';
                    }
                }   
            },'json');
        }
    });
    
}); 
        
