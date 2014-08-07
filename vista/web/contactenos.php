<!--Header Ends================================================ -->
<section id="mapSection"> 
    <div><h1 id="pageTitle"></h1></div>
<div id="myMap" style="height:400px">
<!-- please edit in (js code which is available in the foote section) longitude and longitude of your location  -->
</div>	
</section><br/>
    <section id="sec_contenido" class="well">

<section id="mainBody">							
	<div class="row-fluid">
	    <div class="span1"></div>
			<div class="span5">
			<h3>  Ubiquenos</h3>
                        Jr. San Martín #1205<br/>
                        Tarapoto - San Martin<br/><br/>
                        (042) 525207 <br/>
                        942 914122 <br/>
                        #827860
			</div>
			<div class="span5">
				<h3>  Envienos un correo</h3>
				<form class="form-horizontal">
				<fieldset>
				  <div class="control-group">
				   
					  <input type="text" placeholder="nombre" class="input-xlarge"/>
				   
				  </div>
				   <div class="control-group">
				   
					  <input type="text" placeholder="email" class="input-xlarge"/>
				   
				  </div>
				   <div class="control-group">
				   
					  <input type="text" placeholder="asunto" class="input-xlarge"/>
				  
				  </div>
				  <div class="control-group">
					  <textarea rows="4" id="textarea" class="input-xlarge"></textarea>
				   
				  </div>

					<button class="btn btn-large btn-warning" type="submit"> <i class="icon-envelope"></i> Enviar</button>

				</fieldset>
			  </form>
			</div>
	    <div class="span1"></div>
		</div>
</section>
<script>
$(document).ready(function(){
    $(".li_contactenos").addClass('activo');
});
</script>
<!-- Google map jquery files -->
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script src="<?php echo BASE_URL ?>lib/themes/js/jquery.gmap.js"></script>
	<script>
		// Google map data ==============================================================================
	  $(document).ready(function(){
		$("#myMap").gMap({ 
		    controls: true,
		    scrollwheel: true,
		    draggable: true,
		    markers: [{ 
			latitude: -6.481604,
			longitude: -76.366297,		//your company location longitude
			icon: { 
			    image: "http://www.google.com/mapfiles/marker.png",
			    iconsize: [42, 48],
			    iconanchor: [42,48],
			    infowindowanchor: [14, 0] 
			} 
		    },],
		    icon: { 
			image: "http://www.google.com/mapfiles/marker.png", 
			iconsize: [28, 48],
			iconanchor: [14, 48],
			infowindowanchor: [14, 0] 
		    },
		    latitude: -6.481604,
		    longitude: -76.366297,	
		    zoom: 16
		});
	    });
	</script>