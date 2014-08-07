$(function() {
    $("#nombre").focus();
    $("#fechanacimiento").datepicker({yearRange: '-65:-10', dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true, defaultDate: '1950-1-1'});
    $("#save").click(function() {
        bval = true;
        bval = bval && $("#nombre").required();
        bval = bval && $("#apellido").required();
        bval = bval && $("#direccion").required();
        bval = bval && $("#telefono").required();
        bval = bval && $("#dni").required();
        if(bval && $("#dni").val().length!=8){
            bootbox.alert("El dni debe tener 8 digitos");
            bval = false;
        }
        bval = bval && $("#fechanacimiento").required();
        bval = bval && $("#estadocivil").required();
        bval = bval && $("#id_perfil").required();
        bval = bval && $("#usuario").required();
        bval = bval && $("#clave").required();

        if (bval){
            $("#frm").submit();
        }
        return false;
    });
});