<div class="navbar-inner text-center">
<?php if (isset($this->datos) && count($this->datos)){ ?>
    <div class="row-fluid">
        <div>
            <br/>
            <div class="input-append">
            <select class="m-wrap list" id="filtro">
            <option value="0">Cliente</option>
                </select>
                <input class="m-wrap input-xlarge" type="text" id="buscar" placeholder="Buscar...">    
                <button class="btn btn-inverse" type="button" id="btn_buscar"><i class="icon-search icon-white"></i></button>
        <br/><br/><label>Leyenda:
        <span class="label label-warning">Pendiente</span>
        <span class="label label-danger">Vencido</span></label> 
            </div>
            <br/>
        </div>
    </div>
    <div id="grilla">
    <table id="table" class="table table-striped table-bordered table-hover sortable">
        <thead>
        <tr>
            <th style="display:none"></th>
            <th>Nro Comprobante</th>
            <th>Cliente</th>
            <th>Fecha Venta</th>
            <th>Total</th>
            <th>Monto Cobrado</th>
            <th>Monto Restante</th>
            <th>Accion</th>
        </tr>
        </thead>
        <tbody>
    <?php for ($i = 0; $i < count($this->datos); $i++) {  ?>
    <?php $var = 0; 
        if (isset($this->datos_cuota) && count($this->datos_cuota)){ 
            for ($j = 0; $j < count($this->datos_cuota); $j++) {
                if($this->datos[$i]['ID_VENTA'] == $this->datos_cuota[$j]['ID_VENTA']){
                    if($this->datos_cuota[$j]['MONTO_CUOTA'] ==$this->datos_cuota[$j]['MONTO_COBRADO']){
                        $var = 1;
                    }else{
                        if(new DateTime($this->datos_cuota[$j]['FECHA'],new DateTimeZone('America/Lima'))>new DateTime(date("M d Y"),new DateTimeZone('America/Lima')) && $this->datos_cuota[$j]['MONTO_CUOTA'] > $this->datos_cuota[$j]['MONTO_COBRADO']){
                            $var = 1;
                        }else{
                            $var = 2;
                            break;
                        }
                    }
                }
            }
        }
        if($var == 0){ ?>
            <tr>
        <?php }
        if($var == 1){ ?>
            <tr class="warning">
        <?php }
        if($var == 2){ ?>
            <tr class="error">
        <?php }?>
            <td style="display:none"></td>
            <td><?php echo $this->datos[$i]['NRODOC'] ?></td>
            <td><?php echo $this->datos[$i]['XCLIENTE'] ?></td>
            <td><?php echo $this->datos[$i]['FECHA'] ?></td>
            <td><?php echo number_format(($this->datos[$i]['IGV']+1)*$this->datos[$i]['SUBTOTAL'],2) ?></td>
            <td><?php echo number_format($this->datos[$i]['XMONTO_COBRADO'],2) ?></td>
            <td><?php echo number_format(($this->datos[$i]['IGV']+1)*$this->datos[$i]['SUBTOTAL'] - $this->datos[$i]['XMONTO_COBRADO'],2) ?></td>
            <td align="center">
                <?php if($this->datos[$i]['ESTADOPAGO'] <> 2) {  ?>
                <a href="<?php echo BASE_URL ?>cronogcobro/cronograma/<?php echo $this->datos[$i]['ID_VENTA'].'/'.(($this->datos[$i]['IGV']+1)*$this->datos[$i]['SUBTOTAL'] - $this->datos[$i]['XMONTO_COBRADO'])?>" class="btn btn-info btn-minier"><i class="icon-list-alt icon-white"></i> Cronograma</a>
                <a href="<?php echo BASE_URL ?>cronogcobro/amortizar/<?php echo $this->datos[$i]['ID_VENTA'].'/'.(($this->datos[$i]['IGV']+1)*$this->datos[$i]['SUBTOTAL'] - $this->datos[$i]['XMONTO_COBRADO'])?>" class="btn btn-success btn-minier"><i class="icon-chevron-down icon-white"></i> Amortizar</a>
                <?php if($this->datos[$i]['XMONTO_COBRADO'] != 0) { ?>
                <a target="_blank" href="<?php echo BASE_URL ?>cronogcobro/ticket_pago/<?php echo $this->datos[$i]['ID_VENTA'] ?>" class="btn btn-warning btn-minier"><i class="icon-print icon-white"></i> Imprimir Ticket</a>
                <?php }}else { ?>
                            <a target="_blank" href="javascript:void(0)" onclick="imprimir('<?php echo $this->datos[$i]['ID_VENTA'] ?>','<?php echo $this->datos[$i]['TTIPOCOMPROBANTE'] ?>')" class="btn btn-info btn-minier"><i class="icon-print icon-white"></i> Imprimir</a>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
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

<?php } else{ ?>
    <br/>
    <p>No hay cobros</p>
<?php } ?>  