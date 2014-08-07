<div class="navbar-inner text-center">
<?php if (isset($this->datos) && count($this->datos)) { ?>
    <p>
        <select class="list" id="filtro">
            <option value="0">Empleado</option>
        </select>
        <input type="text" class="input-xlarge" id="buscar">
        <button type="button" class="btn btn-info" id="btn_buscar"><i class="icon-search icon-white"></i></button>
        <a href="<?php echo BASE_URL.'caja/'.$this->action?>" class="btn btn-info"><?php echo $this->lbl_boton ?></a>
        <a href="#myModal" role="button" data-toggle="modal" class="btn btn-info">Ver Saldo Actual</a>
        <br/>
        <input type="text" id="fecha_rep" readonly style="cursor: pointer;margin-top: 10px" />
        <button type="button" id="rep_mov" class="btn btn-info">Reportar Movimientos</button>
    </p>
    <div id="grilla">
    <table id="table" class="table table-striped table-bordered table-hover sortable">
        <thead>
        <tr>
            <th style="display: none"></th>
            <th>Empleado</th>
            <th>Fecha y Hora de  Apertura</th>
            <th>Saldo de Apertura</th>
            <th>Fecha y Hora de  Cierre</th>
            <th>Saldo de Cierre</th>
            <th>Estado</th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < count($this->datos); $i++) { ?>
            <tr>
                <td style="display: none"></td>
                <td><?php echo $this->datos[$i]['EMPLEADO_N'].' '.$this->datos[$i]['EMPLEADO_A'] ?></td>
                <td><?php echo $this->datos[$i]['A_FECHA'] ?></td>
                <td><?php echo $this->datos[$i]['SALDO_AP'] ?></td>
                <td>
                    <?php if($this->datos[$i]['ESTADO']==1){echo 'Caja aún no Cerrada';}else {echo $this->datos[$i]['C_FECHA'];}?>
                </td>
                <td>
                    <?php if($this->datos[$i]['ESTADO']==1){echo 'Caja aún no Cerrada';}else {echo $this->datos[$i]['SALDO_CI'];}?>
                </td>
                <td><?php if($this->datos[$i]['ESTADO']==1){echo 'Aperturado';}else{echo 'Cerrado';}?></td>
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
    
    <!-- Modal -->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Saldo Actual de la Caja</h3>
        </div>
        <div class="modal-body text-justify">
            <div id="bodymodal">
                <div class="text-center">
                    <h4>S/. <?php echo $this->datos[0]['SALDO_CI']; ?></h4>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Ok</button>
        </div>
        </div>
        </div>
    </div>
    <?php } else { ?>
        <br/>
        <p>No hay Caja Aperturada</p>
        <a href="<?php echo BASE_URL?>caja/aperturar" class="btn btn-info">Aperturar</a>
    <?php } ?>