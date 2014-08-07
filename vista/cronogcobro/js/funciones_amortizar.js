$(document).ready(function(){
    $("#monto").focus();
    $("#save").click(function(){
        if($("#monto").val()==''){
            return 0;
        }
        if(parseFloat($("#monto_restante").val())<parseFloat($("#monto").val())){
            alert('El monto restante es solo de S/. '+$("#monto_restante").val());
        }else{
            $("#frm").submit();
        }
    });
});