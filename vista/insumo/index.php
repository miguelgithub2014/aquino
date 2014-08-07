<script>
    var idperfil = <?php echo session::get('idperfil');?>
</script>
<?php if (isset($this->datos) && count($this->datos)) { ?>
<div class="navbar-inner text-center">
    <div class="row-fluid">
        <div>
            <br/>
            <div class="input-append">
            <select class="m-wrap list" id="filtro">
            <option value="0">Descripcion</option>
            <option value="1">Almacen</option>
                </select>
                <input class="m-wrap input-xlarge" type="text" id="buscar" placeholder="Buscar...">    
                <button class="btn btn-inverse" type="button" id="btn_buscar"><i class="icon-search icon-white"></i></button>
                <a href="<?php echo BASE_URL ?>insumo/nuevo" class="btn btn-grey"><i class="icon-plus icon-white"></i></a>
            </div>
            <br/>
        </div>
    </div>
    <div id="grilla">
    <table id="table" class="table table-striped table-bordered table-hover sortable">
        <thead>
        <tr>
            <th>Item</th>
            <th>Insumo</th>
            <th>Almacen</th>
            <th>Unid. Med.</th>
            <th>Stock</th>
            <th>Prec. Compra</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < count($this->datos); $i++) { ?>
            <tr>
                <td><?php echo $i+1 ?></td>
                <td><?php echo $this->datos[$i]['DESCRIPCION'] ?></td>
                <td><?php echo $this->datos[$i]['AALMACEN'] ?></td>
                <td><?php echo $this->datos[$i]['UUNIDADMEDIDA'] ?></td>
                <td><?php echo $this->datos[$i]['STOCK'] ?></td>
                <td><?php echo $this->datos[$i]['PRECIOC'] ?></td>
                <td>
                    <a href="<?php echo BASE_URL?>insumo/asignarunidades/<?php echo $this->datos[$i]['ID_INSUMO'] ?>" title="Asignar Unidad Medida" class="btn btn-info btn-minier"><i class="icon-plus icon-white"></i></a>
                    <a href="javascript:void(0)" title="Editar" onclick="editar('<?php echo BASE_URL?>insumo/editar/<?php echo $this->datos[$i]['ID_INSUMO'] ?>')" class="btn btn-success btn-minier"><i class="icon-pencil icon-white"></i></a>
                    <a href="javascript:void(0)" title="Eliminar" onclick="eliminar('<?php echo BASE_URL?>insumo/eliminar/<?php echo $this->datos[$i]['ID_INSUMO'] ?>')" class="btn btn-danger btn-minier"><i class="icon-remove icon-white"></i></a>
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
    <div class="navbar-inner">
        <br/>
        <p>No hay insumo</p>
        <a href="<?php echo BASE_URL?>insumo/nuevo" class="btn btn-primary">Nuevo</a>
    <?php } ?>