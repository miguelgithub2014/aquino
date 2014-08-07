$(function() {    
    $("#id_unidadmedida").focus(); 
    $("#asignar").click(function(){
        bval = true;   
        bval = bval && $("#id_unidadmedida").required();
        if (bval) {
            $("#asignar").attr('disabled',true);
            $.post(url+"insumo/getUnidadMedida",$("#frm").serialize(),function(response){
                if(response.length){
                    bootbox.alert("La unidad de medida ya fue asignada");
                    $("#asignar").attr('disabled',false);
                }else{
                    $.post(url+"insumo/addUnidadMedida",$("#frm").serialize(),function(responde){
                        if(responde.code=="ok"){
                            window.location.reload();
                        }
                    },'json');
                }
            },'json');
        }
        return false;
    }); 
    
});
var elimina = function(id_p, id_um){
    bootbox.confirm("¿Está seguro de eliminar?", function(result) {
        if(result){
            $.post(url+"insumo/delUnidadMedida",{
                id_insumo:id_p,
                id_unidadmedida:id_um
            },function(responde){
                if(responde.code=="ok"){
                    window.location.reload();
                }
            },'json');
        }
    });
}

var editaprecv = function(id_p, id_um, pvcont,pvcre, um){
    $("#pvcont").val(pvcont);
    $("#pvcre").val(pvcre);
    $("#id_p").val(id_p);
    $("#id_um").val(id_um);
    $("#myModalLabel").html(um)
}
