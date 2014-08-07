<style>   
.sfb{
    padding: 0.5em;
}
 #gallery li{
    list-style: none;
    display: inline-block;
}
.imgfb{
    width: 100px;
    height: 100px;
}
#galeria{
        border: 5px solid #ddd;
        border-radius: 10px;
        padding: 1%;
        margin: 1% 0;
        width: 94.4%;
        background: rgba(255,255,255,0.5);
    }
</style>
<script src="/agrovet/lib/js/sexylightbox.js" type="text/javascript"></script>
<script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>
<script type="text/javascript">
    $(function(){
        SexyLightbox.initialize({color:'blanco', dir: 'sexyimages'});
    })
    function contenido(){
        $("#sec_contenido").html('');
        $.ajax({
            type:"POST",
            url:url+'vista/web/galeria.php',
            beforeSend:function(){
                $("#sec_contenido").html('<div style="width:100%;margin:1em auto;text-align:center"><img src="'+url+'lib/img/loading.gif" /></div>');
            },
            success:function(rpta){
                $("#sec_contenido").html(rpta);
            }
        });
    }
</script>
<link href="/agrovet/lib/css/sexylightbox.css" rel="stylesheet" />
<div id="galeria">
    <div class="container-fluid"><h3>ALBUM DE LA GALERÍA</h3></div>

    <a class="btn btn-success" href="galeria">Ver Lista de Albumes</a><br/><br/>
<?php 
include("fb.php");
$galeria = file_get_contents("http://graph.facebook.com/".$_POST['idfb']."/photos?limit=100"); 
$galeria = json_decode($galeria);

$fotos = $galeria->data;
    $divfotos ='<div id="gallery"><ul class="scroll-pane">';
            foreach($fotos as $idfoto => $foto){
                $divfotos .= '<li><span class="sfb"><a rel="sexylightbox[kmx]" title="Foto '.($idfoto+1).' de la galería" href="'.$foto->source.'"><img class="imgfb" title="Foto '.($idfoto+1).' de la galería" src="'.$foto->picture.'" /></a></span></li>';
            }
    $divfotos .='<br>
        </ul></div>';
echo $divfotos;
?>
    </div>