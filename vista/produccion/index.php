<?php if (isset($this->datos) && count($this->datos)) { ?>
<div class="navbar-inner text-center">
    <div class="row-fluid">
        <div>
            <br/>
            <div class="input-append">
            <select class="m-wrap list" id="filtro">
            <option value="1">Nro. Doc.</option>
            <option value="0">Estado Produccion</option>
                </select>
                <input class="m-wrap input-xlarge" type="text" id="buscar" placeholder="Buscar...">    
                <button class="btn btn-inverse" type="button" id="btn_buscar"><i class="icon-search icon-white"></i></button>
                <a href="<?php echo BASE_URL ?>produccion/nuevo" class="btn btn-grey"><i class="icon-plus icon-white"></i></a>
            </div>
            <br/>
        </div>
    </div>
    <div id="grilla">
    <table id="table" class="table table-striped table-bordered table-hover sortable">
        <thead>
        <tr>
            <th>Item</th>
            <th>Encargado</th>
            <th>Nro Documento</th>
            <th>Tipo Documento</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < count($this->datos); $i++) { ?>
            <tr>
                <td><?php echo $i+1 ?></td>
                <td><?php echo $this->datos[$i]['ENOMBRE'].' '.$this->datos[$i]['EAPELLIDO'] ?></td>
                <td><?php echo $this->datos[$i]['NRODOC'] ?></td>
                <td><?php echo $this->datos[$i]['TTIPOCOMPROBANTE'] ?></td>
                <?php if($this->datos[$i]['ESTADOPRODUCCION']==0) {?> 
                <td style="background: red"></td>
                <?php } else { ?>
                <td style="background: green"></td>
                <?php } ?>
                <td>
                    <a href="#myModal" role="button" data-toggle="modal" title="ver" onclick="ver('<?php echo $this->datos[$i]['ID_PRODUCCION'] ?>')" class="btn btn-warning btn-minier"><i class="icon-eye-open icon-white"></i></a>
                    <?php if($this->datos[$i]['ESTADOPRODUCCION']==0) {?> 
                    <a href="<?php echo BASE_URL?>produccion/entregar/<?php echo $this->datos[$i]['ID_PRODUCCION'] ?>" title="Entregar Produccion" class="btn btn-success btn-minier"><i class="icon-refresh icon-white"></i></a>
                    <a href="javascript:void(0)" onclick="eliminar('<?php echo BASE_URL?>produccion/eliminar/<?php echo $this->datos[$i]['ID_PRODUCCION'] ?>')" class="btn btn-danger btn-minier"><i class="icon-remove icon-white"></i></a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    </div>
	<div id="controls">
		<div id="perpage">
			<select onchange="sorter.size(this.value)">
			<option value="5">5</option>
				<option value="10" selected="selected">10</option>
				<option value="20">20</option>
				<option value="50">50</option>
				<option value="100">100</option>
			</select>
			<span>Entradas por Página</span>
		</div>
		<div id="navigation">
			<img src="<?php echo BASE_URL ?>lib/img/first.gif" width="16" height="16" alt="Primera Página" onclick="sorter.move(-1,true)" />
			<img src="<?php echo BASE_URL ?>lib/img/previous.gif" width="16" height="16" alt="Página Anterior" onclick="sorter.move(-1)" />
			<img src="<?php echo BASE_URL ?>lib/img/next.gif" width="16" height="16" alt="Página Siguiente" onclick="sorter.move(1)" />
			<img src="<?php echo BASE_URL ?>lib/img/last.gif" width="16" height="16" alt="Última Página" onclick="sorter.move(1,true)" />
		</div>
		<div id="text">Página <span id="currentpage"></span> de <span id="pagelimit"></span></div>
	</div>

    <?php } else { ?>
<div class="navbar-inner text-center">
        <br/>
        <p>No hay produccion</p>
        <a href="<?php echo BASE_URL?>produccion/nuevo" class="btn btn-primary">Nuevo</a>
    <?php } ?>

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