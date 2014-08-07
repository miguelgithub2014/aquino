<?php include_once 'funciones.php'; ?>
<!--Header Ends================================================ -->
<!-- Page banner -->
<!-- Page banner end -->
    <section id="sec_contenido" class="well">
	<h3>Servicios</h3>
<section id="mainBody">	
    <?php if(isset($this->datos)&&count($this->datos)){ 
	for($i=0; $i<count($this->datos);$i++){
	    if($i==0 || $i%4==0){?>
		<div class="row-fluid">
	    <?php }
    ?>
	<div class="span3">
	    <ul class="nav nav-list">
		<li><i class="icon-chevron-right"></i> <?php echo ucwords(slug($this->datos[$i]['TITULO'])) ?></li>
	    </ul>
	</div>
    <?php
	    if(($i+1)%4==0 || ($i+1)==count($this->datos)){ ?>
    </div>
	    <?php }
    }} ?>
</section>
<script>
$(document).ready(function(){
    $(".li_servicios").addClass('activo');
});
</script>