<div class="navbar-inner">
    <form method="post" action="<?php if(isset ($this->action))echo $this->action ?>" id="frm">
    <input type="hidden" name="guardar" id="guardar" value="1"/>
    <input type="hidden" readonly="readonly" name="codigo" id="codigo"
                value="<?php if(isset ($this->datos[0]['ID_INSUMO']))echo $this->datos[0]['ID_INSUMO']?>"/>
    <table align="center" cellpadding="10">
        <tr>
            <td><label>Almacen</label></td>
            <td>
                <select name="id_almacen" id="id_almacen">
                    <option value="0"></option>
                    <?php for($i=0;$i<count($this->datos_almacen);$i++){ ?>
                        <?php if( $this->datos[0]['ID_ALMACEN'] == $this->datos_almacen[$i]['ID_ALMACEN'] ){ ?>
                    <option value="<?php echo $this->datos_almacen[$i]['ID_ALMACEN'] ?>" selected="selected"><?php echo utf8_encode($this->datos_almacen[$i]['DESCRIPCION']) ?></option>
                        <?php } else { ?>
                    <option value="<?php echo $this->datos_almacen[$i]['ID_ALMACEN'] ?>"><?php echo utf8_encode($this->datos_almacen[$i]['DESCRIPCION']) ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><label>Descripcion:</label></td>
            <td><input type="text" name="descripcion" id="descripcion" 
               value="<?php if(isset ($this->datos[0]['DESCRIPCION']))echo $this->datos[0]['DESCRIPCION']?>"/></td>
        </tr>
        <td><label>Unidad de Medida</label></td>
        <td>
            <select name="id_unidadmedida" id="id_unidadmedida">
                <option value="0"></option>
                <?php for($i=0;$i<count($this->datos_unidadmedida);$i++){ ?>
                    <?php if( $this->datos[0]['ID_UNIDADMEDIDA'] == $this->datos_unidadmedida[$i]['ID_UNIDADMEDIDA'] ){ ?>
                <option value="<?php echo $this->datos_unidadmedida[$i]['ID_UNIDADMEDIDA'] ?>" selected="selected"><?php echo utf8_encode($this->datos_unidadmedida[$i]['DESCRIPCION']) ?></option>
                    <?php } else { ?>
                <option value="<?php echo $this->datos_unidadmedida[$i]['ID_UNIDADMEDIDA'] ?>"><?php echo utf8_encode($this->datos_unidadmedida[$i]['DESCRIPCION']) ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
        </td>
        <tr>
            <td colspan="2" align="center">
                <p><button type="submit" class="btn btn-primary" id="save">Guardar</button>
                <a href="<?php echo BASE_URL ?>insumo" class="btn btn-info">Cancelar</a></p>
            </td>
        </tr>
    </table>
</form>