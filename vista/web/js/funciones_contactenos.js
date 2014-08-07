/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    $(".horayfecha").kendoDateTimePicker({
        format: "dd-MM-yyyy HH:mm"
    });
});

function validarContacto(){
    n = $("#nombreContacto").val();
    e = $("#emailContacto").val();
    t = $("#telefonoContacto").val();
    m = $("#mensaje").val();
    if(n == ""){
        alert("Debe ingresar nombre");
        $("#nombreContacto").focus();
        return false;
    }
    else{
        if(e == ""){
            alert("Debe ingresar email");
            $("#emailContacto").focus();
            return false;
        }
        else{
            if(t == ""){
                alert("Debe ingresar etelefono");
                $("#telefonoContacto").focus();
                return false;
            }
            else{
                if(m == ""){
                    alert("Debe ingresar mensaje");
                    $("#mensaje").focus();
                    return false;
                }
                else return true;
            }
        }
    }
}
