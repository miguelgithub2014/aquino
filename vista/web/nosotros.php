<?php include_once 'funciones.php'; ?>
<!--Header Ends================================================ -->
<!-- Page banner -->
<!-- Page banner end -->
    <section id="sec_contenido" class="well">
	<h3>Nosotros</h3>
<section id="mainBody">	
    <div class="row-fluid">
	<div class="span8">
	    <img class="img-polaroid" alt="" src="<?php echo BASE_URL ?>lib/img/nosotros.jpg" /><br/><br/>
	    <p class="text-justify">
		<?php 
		$var = $this->datos[0]['CONOCENOS'];
		$var = str_replace("\r","<div style='height:5px'></div>",$var);
		echo ucfirst(slug($var))
		?>
	    </p>		
	</div>
	<div class="span4">
	    <h4>Misión</h4>
	    <p class="text-justify">
		<?php 
		$var = $this->datos[0]['MISION'];
		$var = str_replace("\r","<div style='height:5px'></div>",$var);
		echo ucfirst(slug($var))
		?>
	    </p><br/>
	    <h4>Visión</h4>
	    <p class="text-justify">
		<?php 
		$var = $this->datos[0]['VISION'];
		$var = str_replace("\r","<div style='height:5px'></div>",$var);
		echo ucfirst(slug($var))
		?>
	    </p>
	</div>
    </div>
</section>
<script>
$(document).ready(function(){
    $(".li_nosotros").addClass('activo');
});
</script>