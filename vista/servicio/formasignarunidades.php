<script src="<?php echo $_params['ruta_js']; ?>bootbox.min.js"></script>
<div class="navbar-inner">
    <form id="frm">
        <input type="hidden" readonly="readonly" name="codigo" id="codigo"
               value="<?php if (isset($this->id_servicio)) echo $this->id_servicio ?>"/>
        <table align="center" cellpadding="10">
            <tr>
                <td><label>Unidad de Medida:</label></td>
                <td>
                    <select name="id_unidadmedida" id="id_unidadmedida">
                        <option value="0"></option>
                        <?php for ($i = 0; $i < count($this->datos_detservicioum); $i++) { ?>
                            <option value="<?php echo $this->datos_detservicioum[$i]['ID_UNIDADMEDIDA'] ?>"><?php echo utf8_encode($this->datos_detservicioum[$i]['DESCRIPCION']) ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td><label>Precio Venta:</label></td>
                <td><input type="text" id="preciov" name="preciov" class="input-small"/></td>
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
                    <th>Pre. Venta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $x = 0;
                for ($i = 0; $i < count($this->datos); $i++) { ?>
                    <tr>
                        <td><?php echo++$x ?></td>
                        <td><?php echo $this->datos[$i]['UUNIDADMEDIDA'] ?></td>
                        <td><?php echo $this->datos[$i]['PRECIOV'] ?></td>
                        <td>
                            <a href="#myModal" role="button" title="Editar Preciosx" data-toggle="modal" onclick="editaprecv('<?php echo $this->datos[$i]['ID_SERVICIO'] ?>','<?php echo $this->datos[$i]['ID_UNIDADMEDIDA'] ?>','<?php echo $this->datos[$i]['PRECIOV'] ?>','<?php echo $this->datos[$i]['UUNIDADMEDIDA'] ?>')" class="btn btn-success btn-minier"><i class="icon-pencil icon-white"></i></a>
                            <a href="javascript:void(0)" onclick="elimina('<?php echo $this->datos[$i]['ID_SERVICIO'] ?>','<?php echo $this->datos[$i]['ID_UNIDADMEDIDA'] ?>')" class="btn btn-danger btn-minier"><i class="icon-remove icon-white"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <table align="center" cellpadding="10">
        <tr>
            <td colspan="2" align="center">
                <a href="<?php echo BASE_URL ?>servicio" class="btn btn-info">Aceptar</a></p>
            </td>
        </tr>
    </table>
    
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel"></h3>
        </div>
        <div class="modal-body text-justify">
            <input type="hidden" id="id_s"/>
            <input type="hidden" id="id_um"/>
            Prec. Venta:<input type="text" id="pv" value="" class="input-small"/>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" id="ok">Ok</button>
        </div>
        </div>
        </div>
    </div>