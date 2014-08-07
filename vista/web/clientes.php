<!--Header Ends================================================ -->
<!-- Page banner -->
<!-- Page banner end -->
    <section id="sec_contenido" class="well">
	<h3>Clientes</h3>
<section id="mainBody">	
    <?php if(isset($this->datos)&&count($this->datos)){ 
	for($i=0; $i<count($this->datos);$i++){
	    if($i==0 || $i%4==0){?>
		<div class="row-fluid text-center">
	    <?php }
    ?>
	<div class="span3">
	    <a href="<?php echo strtolower($this->datos[$i]['URL']) ?>" target="_blank">
	    <img src="<?php echo BASE_URL ?>lib/img/clientes/<?php echo strtolower($this->datos[$i]['IMAGEN']) ?>"
	    title="<?php echo $this->datos[$i]['TITULO'] ?>" alt="" class="img-polaroid"  />
	    </a>
	</div>
    <?php
	    if(($i+1)%4==0 || ($i+1)==count($this->datos)){ ?>
    </div>
	    <?php }
    }} ?>
</section>
<script>
$(document).ready(function(){
    $(".li_clientes").addClass('activo');
});
</script>