$(function() {    
    $("#id_unidadmedida").focus(); 
    $("#asignar").click(function(){
        var bval = true;   
        bval = bval && $("#id_unidadmedida").required();
        bval = bval && $("#preciov").required();
        if (bval) {
            $("#asignar").attr('disabled',true);
            $.post(url+"servicio/getUnidadMedida",$("#frm").serialize(),function(response){
                if(response.length){
                    bootbox.alert("La unidad de medida ya fue asignada");
                    $("#asignar").attr('disabled',false);
                }else{
                    $.post(url+"servicio/addUnidadMedida",$("#frm").serialize(),function(responde){
                        if(responde.code=="ok"){
                            window.location.reload();
                        }
                    },'json');
                }
            },'json');
        }
        return false;
    }); 
    $("#ok").click(function(){
        $.post(url+"servicio/actPreciov",{
            id_servicio: $("#id_s").val(),
            id_unidadmedida: $("#id_um").val(),
            preciov: $("#pv").val()
        },function(responde){
            if(responde.code=="ok"){
                window.location.reload();
            }
        },'json');
    });
});
var elimina = function(id_s, id_um){
    bootbox.confirm("¿Está seguro de eliminar?", function(result) {
        if(result){
            $.post(url+"servicio/delUnidadMedida",{
                id_servicio:id_s,
                id_unidadmedida:id_um
            },function(responde){
                if(responde.code=="ok"){
                    window.location.reload();
                }
            },'json');
        }
    });
};

var editaprecv = function(id_s, id_um, pv, um){
    $("#id_s").val(id_s);
    $("#id_um").val(id_um);
    $("#pv").val(pv);
    $("#myModalLabel").html(um);
};