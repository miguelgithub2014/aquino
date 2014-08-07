
    <script>
    function producto(id){
            $("#myModalLabel2").html('');
            $("#bodymodal2").html('<div class="text-center"><img src="'+url+'lib/img/loading.gif" /></div>');
            html='';titulo='';
           $.post(url+'web/verp','id='+id,function(datos){
                titulo = datos[0].TITULO;
                imagen = datos[0].IMAGEN;
                html += "<br><br><div class='text-center'><img src='"+url+"lib/img/productos/"+imagen.toLowerCase()+"' /></div>";
                rep = datos[0].CUERPO.replace(/\s*[\r\n][\r\n \t]*/g, "<br><br>");
                html += '<br><br><article>'+rep+'</article>';
                $("#myModalLabel2").html(titulo);
                $("#bodymodal2").html(html);
           },'json');
       }
       </script>

<!--Header Ends================================================ -->
<!-- Page banner -->
<section id="bannerSection" style="background:url(<?php echo BASE_URL ?>lib/themes/images/bg.jpg) no-repeat center center #000;">
	<div>	
		<h1 id="pageTitle">Nuestros Productos
		</h1>
	</div>
</section> 
<!-- Page banner end -->
<section id="bodySection">
<div>					
<div class="row-fluid">						
<div class="span9">						
<div class="thumbnail">
<h3><a href="#" title="my web solutions">Productos más destacados</a></h3>    
<div id="div_prod">
    <?php if (isset($this->datos) && count($this->datos)) {
        $cont = 0; ?>
    <?php for ($i = 0; $i < count($this->datos); $i++) {  
            if($cont == 0){
                echo '<div class="row-fluid">';
            }
        ?>
        <div class="span4">
            <br/>
            <div class="imagen_p"><img src="<?php echo BASE_URL ?>lib/img/productos/<?php echo $this->datos[$i]['IMAGEN'] ?>" /></div>
            <div class="titulo_p"><?php echo $this->datos[$i]['TITULO'] ?></div>
            <a href="#myModal2" role="button" data-toggle="modal" 
                onclick="producto('<?php echo $this->datos[$i]['ID'] ?>')" class="btn btn-default btn-block">
                Mas Detalles
            </a>
            <br/>
        </div>
    <?php 
        $cont++;
        if($cont == 3){
            echo '</div>';
            $cont = 0;
        } else{
            if($i == (count($this->datos)-1)){
                if($cont == 1){
                    echo '<div class="span4"></div><div class="span4"></div></div>';
                    $cont = 0;
                }
                if($cont == 2){
                    echo '<div class="span4"></div></div>';
                    $cont = 0;
                }
            }
        }
        } 
        }  ?>
    </div>
    <br>
    <div id="paginacion">
        <?php if(isset($this->paginacion)) echo $this->paginacion ?>
    </div>
    </div>
<br/>
</div>


<!-- Sidebar comumn -->
<div class="span3">
<div class="well well-small">
<h4>Buscar</h4>

<select name="id_categoria" id="id_categoria" class="input-block-level">
    <option value="">Seleccione Categoria...</option>
    <?php for($i=0;$i<count($this->datos_categoria);$i++){ ?>
    <option value="<?php echo $this->datos_categoria[$i]['ID_CATEGORIA'] ?>"><?php echo utf8_encode($this->datos_categoria[$i]['DESCRIPCION']) ?></option>
        <?php } ?>
</select>
<select name="id_subcategoria" id="id_subcategoria" class="input-block-level">
    <option value="">Seleccione Subcategoria...</option>
</select>
<button type="button" class="btn btn-block btn-success" id="buscar_prod" disabled="false">Buscar</button>
</div>
</div>



</div>
</div>
</section>
<script>
$(document).ready(function(){
    $(".li_index").removeClass('active');
    $(".li_productos").addClass('active');
    
    $("#id_categoria").change(function(){
        $("#id_subcategoria").html('<option></option>');
        if($(this).val()!=0){
            $("#id_subcategoria").html('<option>Cargando...</option>');
            $.post(url+'web/getSubcategoriaAjax','id_categoria='+$(this).val(),function(datos){
                $("#id_subcategoria").html('<option value="">Seleccione Subcategoria...</option>');
                for(var i=0;i<datos.length;i++){
                    if(i!=0){
                        $("#id_subcategoria").append('<option value="'+ datos[i].ID_SUBCATEGORIA + '">' + datos[i].DESCRIPCION+ '</option>');
                    }
                }       
            },'json');
        }
    });
    $("#id_subcategoria").change(function(){
        if($("#id_subcategoria").val()!=''){
            $("#buscar_prod").removeAttr("disabled");
        }else{
            $("#buscar_prod").attr("disabled","true");
        }
    });
    $("#buscar_prod").click(function(){
        bval = true;   
        bval = bval && $("#id_categoria").required();
        bval = bval && $("#id_subcategoria").required();
        
        if (bval) 
        {
            
            subcategoria = $("#id_subcategoria option:selected").html();
            $("#div_prod").html('<div class="text-center"><img src="'+url+'lib/img/loading.gif" /></div>');
            $("#paginacion").hide();
            $.post(url+'web/getProductos','id_subcategoria='+$("#id_subcategoria").val(),function(datos){
                cont = 0;
                cont2 = 0;
                html = '';
                if(datos.length > 0){
                    html += '<h4>Subcategoria: '+subcategoria+'</h4>';
                    for(var i=0; i<datos.length; i++){
                        if(cont == 0){
                            html += '<div class="row-fluid">';
                        }
                        html += '<div class="span4">'+
                            '<br/>'+
                            '<div class="imagen_p"><img src="'+url+'lib/img/productos/'+datos[i].IMAGEN+'" /></div>'+
                            '<div class="titulo_p">'+datos[i].TITULO+'</div>'+
                            '<a href="#myModal2" role="button" data-toggle="modal" onclick="producto(\''+datos[i].ID+'\')" class="btn btn-default btn-block">'+
                                'Mas Detalles'+
                            '</a>'+
                            '<br/>'+
                        '</div>';
                        cont++;
                        cont2++;
                        if(cont == 3 || cont2 == (datos.length)){
                            html += '</div>';
                            cont = 0;
                        }
                    }
                }else{
                    html += '<h4>No hay productos en esta subcategoria</h4>';
                }
                $("#div_prod").html(html);
            },'json');
        }
        return false;
    });
});
</script>