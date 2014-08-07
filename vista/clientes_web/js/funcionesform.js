/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    $( "#titulonot" ).focus();
    $( "#save" ).click(function(){
        bval = true;        
        bval = bval && $( "#titulonot" ).required();
        bval = bval && $( "#url" ).required();
        bval = bval && $( "#imagen" ).required();
        
        if (bval) 
        {
            $("#frm").submit();
        }
        return false;
    }); 
});
function cambiar_imagen(){
    if(confirm("¿Esta seguro que desea cambiar de imagen?")){
        titulo = "input[id=archivo]";
        html = '<input id="archivo" name="archivo" type="file" style="display: none" />';
        html += '<div class="input-append">';
        html += '<input id="imagen" class="form-control" type="text" disabled style="display: inline-block; width: 85%" />';
        html += '<a class="btn btn-info" onclick="$(\''+titulo+'\').click();"><i class="icon-search"></i></a></div>';
        html += '<input type="hidden" value="1" id="modificar_imagen" name="modificar_imagen" /></div>';
        $("#imagen_subida").html(html);
        script = "<script>";
        script += "$('input[id=archivo]').change(function(){";
        script += "$('#imagen').val($(this).val());})";
        script += "</script>";
        $("#script").html(script);
    }
}