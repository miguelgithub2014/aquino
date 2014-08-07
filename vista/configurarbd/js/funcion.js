/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(function() {    
    $( "#sqbd" ).focus();   
    $( "#save" ).click(function(){
        bval = true;   
        bval = bval && $("#sgbd").required();
        bval = bval && $("#usuario").required();
        bval = bval && $("#host").required();
        bval = bval && $("#puerto").required();
        bval = bval && $("#basedatos").required();
        
        if (bval) 
        {
            $("#frm").submit();
        }
        return false;
    }); 
});