<script src="<?php echo $_params['ruta_js']; ?>bootbox.min.js"></script>
<div class="navbar-inner">
    <form id="frm">
        <input type="hidden" readonly="readonly" name="codigo" id="codigo"
               value="<?php if (isset($this->id_insumo)) echo $this->id_insumo ?>"/>
        <table align="center" cellpadding="10">
            <tr>
                <td><label>Unidad de Medida:</label></td>
                <td>
                    <select name="id_unidadmedida" id="id_unidadmedida">
                        <option value="0"></option>
                        <?php for ($i = 0; $i < count($this->datos_detinsumoum); $i++) { ?>
                            <option value="<?php echo $this->datos_detinsumoum[$i]['ID_UNIDADMEDIDA'] ?>"><?php echo utf8_encode($this->datos_detinsumoum[$i]['DESCRIPCION']) ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td id="celda_aceptar">
                    <a href="javascript:void(0)" class="btn btn-primary" id="asignar" title="Asignar"><i class="icon-plus icon-white"></i></a>
                </td>
            </tr>
        </table>
    </form>
    <div id="grilla">
        <table id="table" class="table table-striped table-bordered table-hover sortable">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Unidad Medida</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $x = 0;
                for ($i = 0; $i < count($this->datos); $i++) { ?>
                    <tr>
                        <td><?php echo++$x ?></td>
                        <td><?php echo $this->datos[$i]['UUNIDADMEDIDA'] ?></td>
                        <td>
                    <?php if ($this->datos[$i]['EQUIVALENTEUNIDAD'] != '0'): ?>
                            <a href="javascript:void(0)" onclick="elimina('<?php echo $this->datos[$i]['ID_INSUMO'] ?>','<?php echo $this->datos[$i]['ID_UNIDADMEDIDA'] ?>')" class="btn btn-danger btn-minier"><i class="icon-remove icon-white"></i> Eliminar</a>
                    <?php endif; ?>
                        </td>
                    </tr>
<?php } ?>
            </tbody>
        </table>
    </div>
    <table align="center" cellpadding="10">
        <tr>
            <td colspan="2" align="center">
                <a href="<?php echo BASE_URL ?>insumo" class="btn btn-info">Aceptar</a></p>
            </td>
        </tr>
    </table>