<div class="navbar-inner text-center">
<?php if (isset($this->datos) && count($this->datos)) { ?>
    <br/>
    <a href="<?php echo BASE_URL?>informacion/editar" class="btn btn-grey">Editar</a></br></br>
    <div class="row-fluid">
        <div class="span3">
            Nosotros</br>
            <a href="#myModal" role="button" data-toggle="modal" onclick="ver('1')" class="btn btn-success">Ver Información</a>
	    </br></br>
        </div>
        <div class="span3">
            Misión<br>
            <a href="#myModal" role="button" data-toggle="modal" onclick="ver('2')" class="btn btn-success">Ver Información</a>
	    </br></br>
        </div>
        <div class="span3">
            Visión<br>
            <a href="#myModal" role="button" data-toggle="modal" onclick="ver('3')" class="btn btn-success">Ver Información</a>
	    </br></br>
        </div>
    </div>
    <br/>
<?php } ?>
    
    <!-- Modal -->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel"></h3>
        </div>
        <div class="modal-body text-justify">
            <div id="bodymodal">
                <div class="text-center">
                    <img src="<?php echo BASE_URL ?>lib/img/loading.gif" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Ok</button>
        </div>
        </div>
        </div>
    </div>