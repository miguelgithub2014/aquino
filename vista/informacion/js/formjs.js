/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){   
    $( "#save" ).click(function(){
        bval = true;        
        bval = bval && $("#conocenos").required();
        bval = bval && $("#mision").required();
        bval = bval && $("#vision").required();
        bval = bval && $("#historia").required();
        
        if (bval) 
        {
            $("#frm").submit();
        }
        return false;
    }); 
});
