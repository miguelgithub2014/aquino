<div class="navbar-inner">
    <form method="post" action="<?php if(isset ($this->action))echo $this->action ?>" id="frm">
    <input type="hidden" name="guardar" id="guardar" value="1"/>
    <input type="hidden" readonly="readonly" name="codigo" id="codigo"
                value="<?php if(isset ($this->datos[0]['ID_UNIDADMEDIDA']))echo $this->datos[0]['ID_UNIDADMEDIDA']?>"/>
    <table align="center" cellpadding="10">
        <tr>
            <td><label>Descripcion:</label></td>
            <td><input type="text" name="descripcion"
               id="descripcion" value="<?php if(isset ($this->datos[0]['DESCRIPCION']))echo $this->datos[0]['DESCRIPCION']?>"/></td>
        </tr>
        <tr>
            <td><label>Prefijo:</label></td>
            <td><input type="text" name="prefijo"
               id="prefijo" value="<?php if(isset ($this->datos[0]['PREFIJO']))echo $this->datos[0]['PREFIJO']?>"/></td>
        </tr>
        <tr>
            <td><label>Unidad Base:</label></td>
            <td>
                <select name="equivalenteunidad" id="equivalenteunidad">
                    <option value="0">UNIDAD BASE</option>
                    <?php for($i=0;$i<count($this->datos_unidadbase);$i++){ ?>
                        <?php if( $this->datos[0]['EQUIVALENTEUNIDAD'] == $this->datos_unidadbase[$i]['ID_UNIDADMEDIDA'] ){ ?>
                    <option value="<?php echo $this->datos_unidadbase[$i]['ID_UNIDADMEDIDA'] ?>" selected="selected"><?php echo utf8_encode($this->datos_unidadbase[$i]['DESCRIPCION']) ?></option>
                        <?php } else { ?>
                    <option value="<?php echo $this->datos_unidadbase[$i]['ID_UNIDADMEDIDA'] ?>"><?php echo utf8_encode($this->datos_unidadbase[$i]['DESCRIPCION']) ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><label>Cantidad:</label></td>
            <td><input type="text" name="cant_unidad" onkeypress="return soloNumeros(event)"
               id="cant_unidad" value="<?php if(isset ($this->datos[0]['CANT_UNIDAD']))echo $this->datos[0]['CANT_UNIDAD']?>"/></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <p><button type="submit" class="btn btn-primary" id="save">Guardar</button>
                <a href="<?php echo BASE_URL ?>unidadmedida" class="btn btn-info">Cancelar</a></p>
            </td>
        </tr>
    </table>
</form>