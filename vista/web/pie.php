</div>
</section>
<!-- Footer
  ================================================== -->
<section id="footerSection">
<div class="container-fluid">
    <footer class="footer">
	<div class="row-fluid">
	
            <div class="span2"></div>
	
	<div class="span4">
			<h4>Visitanos</h4>
                        <address style="margin: 0">
				Jr. San Martín #1205<br>
				Tarapoto - San Martin
			</address>
        </div>
	<div class="span4">
            <br/>
			Telefono: (042) 525207<br>
			Celular: 942 914122<br>
			RPM: #827860
        </div>
            <div class="span2"></div>
    </div>
	</footer>
    </div><!-- /container -->
</section>
</div>
<!-- Modal -->
<div class="modal fade hide" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title">
	    Inicio de Sesión
	</h3>
      </div>
      <div class="modal-body">
            <form action="<?php echo BASE_URL?>login" method="post" id="mc-form">
		<div class="row-fluid">
		<div class="span6 text-center">
		<img src="<?php echo BASE_URL ?>lib/themes/images/pokebola.png" width="70%"/><br/><br/>
		<img src="<?php echo BASE_URL ?>lib/themes/images/titulo.png" width="80%"/></div>
		<div class="span6" style="padding-top: 30px">
		<div class="form-group">
			<label for="usuario">Usuario</label>
			<input class="form-control" required class="field" type="text" name="usuario" id="usuario" placeholder="Ingrese usuario...">
		  </div>
		  <div class="form-group">
			<label for="clave">Clave</label>
			<input class="form-control" required type="password" name="clave" id="clave" placeholder="Ingrese clave...">
		  </div>
		  <div class="form-group">
                    <div id="mc">
                        <canvas id="mc-canvas">
                                Your browser doesn't support the canvas element - please visit in a modern browser.
                        </canvas>
                    </div>
		  </div>
		  <input type="submit" id="formsubmit" disabled="disabled" class="btn btn-warning" value="Ingresar" />
		  <button type="reset" onclick="$('#usuario').focus()" class="btn">Limpiar</button>
		  </div>
		</div>
		  
            </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
    <div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel2"></h3>
        </div>
        <div class="modal-body text-justify">
            <div id="bodymodal2">
                <div class="text-center">
                    <img src="<?php echo BASE_URL ?>lib/img/loading.gif" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Ok</button>
        </div>
    </div>
<a href="#" class="btn btn-warning" style="position: fixed; bottom: 10px; right: 10px; display: none; " id="toTop">
    <i class="icon-chevron-up"></i> Ir arriba
</a>
<!-- Javascript
    ================================================== -->
	<script src="<?php echo BASE_URL ?>lib/js/bootstrap.min.js"></script>
	<script src="<?php echo BASE_URL ?>lib/themes/js/bootshop.js"></script>
    <script src="<?php echo $_params['ruta_js']; ?>jquery.motionCaptcha.js"></script>
	<script>
	    /* Go to top */
	    $(function() {
		$('#mc-form').motionCaptcha({
		    shapes: ['triangle', 'x', 'rectangle', 'circle', 'check', 'zigzag', 'arrow', 'delete', 'pigtail', 'star']
		});
		    $(window).scroll(function() {
			    if($(this).scrollTop() > 50) {
				    $('#toTop').fadeIn();	
			    } else {
				    $('#toTop').fadeOut();
			    }
		    });

		    $('#toTop').click(function() {
			    $('body,html').animate({scrollTop:0},800);
		    });	
	    });
	</script>
        
</body>
</html>