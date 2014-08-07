<!--Header Ends================================================ -->
<link rel="stylesheet" href="<?php echo BASE_URL ?>lib/css/themes/default/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo BASE_URL ?>lib/css/nivo-slider.css" type="text/css" media="screen" />

<section id="carouselSection" style="margin: 0 auto;">
    <div id="div_carousel" style="width: 100%; margin: 0 auto; padding-top: 1%;">
    <div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider">  
		    <img src="<?php echo BASE_URL ?>lib/img/slide/slide11.png" alt="" />           
		    <img src="<?php echo BASE_URL ?>lib/img/slide/slide12.png" alt="" />           
            </div>
        </div>
    </div>
<br/>
</section>
    <section id="sec_contenido" class="well">
<section id="mainBody">
    <div class="row-fluid">
	<div class="span4">
	    <h4>
		<i class="icon-home"></i>
		Quiénes Somos
	    </h4>
	    <p class="text-justify">
		Somos especialistas en comprobantes de pagos, miles de clientes satisfechos son nuestra mejor garantía,....
	    </p>
	    <a class="btn btn-warning pull-right" href="<?php echo BASE_URL ?>web/nosotros">
		Leer más
		<i class="icon-chevron-right"></i>
	    </a>
	</div>
	<div class="span4">
	    <h4>
		<i class="icon-cog"></i>
		Servicios
	    </h4>
	    <p class="text-justify">
		Le ofrecemos el mejor servicio de impresión con los mejores precios del mercado y con tecnología de punta que nos permite la entrega oportuna de nuestros trabajos...
	    </p>
	    <a class="btn btn-warning pull-right" href="<?php echo BASE_URL ?>web/servicios">
		Leer más
		<i class="icon-chevron-right"></i>
	    </a>
	</div>
	<div class="span4">
	    <h4>
		<i class="icon-map-marker"></i>
		Contáctenos
	    </h4>
	    <p class="text-justify">
	Si desea que le enviemos una cotización sobre algunos de nuestros servicios, escríbanos en nuestra página web o llámenos a los números,...
	    </p>
	    <a class="btn btn-warning pull-right" href="<?php echo BASE_URL ?>web/contactenos">
		Leer más
		<i class="icon-chevron-right"></i>
	    </a>
	</div>
    </div>
    <div class="line"></div>
    <h3>Servicios</h3>
    <div class="row-fluid text-center">
	<?php $cont = 0; for($i=0; $i<count($this->datos_s);$i++){ 
	if($this->datos_s[$i]['IMAGEN']!='' && $cont<4){ $cont++; ?>
	<div class="span3">
	    <img src="<?php echo BASE_URL ?>lib/img/servicios/<?php echo strtolower($this->datos_s[$i]['IMAGEN']) ?>"
		 title="<?php echo $this->datos_s[$i]['TITULO'] ?>" alt="" class="img-polaroid"  />
	    <h5><?php echo ucwords(strtolower($this->datos_s[$i]['TITULO'])) ?></h5>
	</div>
	<?php }} ?>
    </div>
    <div class="line"></div>
    <h3>Principantes Clientes</h3>
    <div class="row-fluid text-center">
	<?php for($i=0; $i<count($this->datos_c);$i++){ 
	if($i<4){ ?>
	<div class="span3">
	    <a href="<?php echo strtolower($this->datos_c[$i]['URL']) ?>" target="_blank">
	    <img src="<?php echo BASE_URL ?>lib/img/clientes/<?php echo strtolower($this->datos_c[$i]['IMAGEN']) ?>"
		 title="<?php echo $this->datos_c[$i]['TITULO'] ?>" alt="" class="img-polaroid"  />
	    </a>
	</div>
	<?php }} ?>
    </div>
</section>


<!-- body block end======================================== -->
        <!-- Load the CloudCarousel JavaScript file -->
        
        <script type="text/javascript" src="<?php echo BASE_URL ?>lib/js/jquery.nivo.slider.js"></script>
    <script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider();
    });
    $(function(){
	$(".li_index").addClass('activo');
	$('.img-polaroid').tooltip();
    })
    </script>
