<script src="<?php echo $_params['ruta_js']; ?>bootbox.min.js"></script>
<?php if (isset($this->datos) && count($this->datos)) { ?>
<div class="navbar-inner">
    <form id="frm">
        <input type="hidden" readonly="readonly" name="codigo" id="codigo"
               value="<?php if (isset($this->id_producto)) echo $this->id_producto ?>"/>
        <table align="center" cellpadding="10">
            <tr>
                <td>
                    
                    <div id="grilla">
                        <table id="table" class="table table-striped table-bordered table-hover sortable">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Fecha</th>
                                    <th>Glosa</th>
                                    <th>Tipo</th>
                                    <th>Unidad Medida</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < count($this->datos); $i++) {?>
                                    <tr>
                                        <td><?php echo ($i+1) ?></td>
                                        <td><?php echo $this->datos[$i]['FECHA'] ?></td>
                                        <td><?php echo $this->datos[$i]['GLOSA'] ?></td>
                                        <td><?php echo $this->datos[$i]['TIPO'] ?></td>
                                        <td><?php echo $this->datos[$i]['UUNIDADMEDIDA'] ?></td>
                                        <td><?php echo $this->datos[$i]['CANTIDAD'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </form>
    <?php } else { ?>
    <div class="navbar-inner">
        <br/>
        <p>No hay movimientos de este producto</p>
    <?php } ?>
    <table align="center" cellpadding="10">
        <tr>
            <td colspan="2" align="center">
                <a href="<?php echo BASE_URL ?>producto" class="btn btn-info">Aceptar</a></p>
            </td>
        </tr>
    </table>