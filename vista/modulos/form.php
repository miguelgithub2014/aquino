<div class="navbar-inner">
    <form method="post" action="<?php if(isset ($this->action))echo $this->action ?>" id="frm">
    <input type="hidden" name="guardar" id="guardar" value="1"/>
    <input type="hidden" readonly="readonly" name="codigo" id="codigo"
                value="<?php if(isset ($this->datos[0]['IDMODULO']))echo $this->datos[0]['IDMODULO']?>"/>
    <table align="center" cellpadding="10">
        <tr>
            <td><label>Descripcion:</label></td>
            <td><input type="text" name="descripcion" onkeypress="return soloLetras(event)"
                       id="descripcion" value="<?php if(isset ($this->datos[0]['DESCRIPCION']))echo $this->datos[0]['DESCRIPCION']?>"/></td>
        </tr>
        <tr>
            <td><label>Icono:</label></td>
            <td><input type="text" name="icono" 
                       id="icono" value="<?php if(isset ($this->datos[0]['ICONO']))echo $this->datos[0]['ICONO']?>"/></td>
        </tr>
        <tr>
            <td><label>Url:</label></td>
            <td><input type="text" name="url"
                       id="url" value="<?php if(isset ($this->datos[0]['URL']))echo $this->datos[0]['URL']?>"/></td>
        </tr>
        <tr>
            <td><label>Modulo Padre:</label></td>
            <td>
                <select  id="modulo_padre" name="modulo_padre">
                    <?php for($i=0;$i<count($this->modulos_padre);$i++){ ?>
                        <?php if( $this->datos[0]['IDMODULO_PADRE'] == $this->modulos_padre[$i]['IDMODULO'] ){ ?>
                    <option value="<?php echo $this->modulos_padre[$i]['IDMODULO'] ?>" selected="selected"><?php echo $this->modulos_padre[$i]['DESCRIPCION'] ?></option>
                        <?php } else { ?>
                    <option value="<?php echo $this->modulos_padre[$i]['IDMODULO'] ?>"><?php echo $this->modulos_padre[$i]['DESCRIPCION'] ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <p><button type="submit" class="btn btn-primary" id="save">Guardar</button>
                <a href="<?php echo BASE_URL ?>modulos" class="btn btn-info">Cancelar</a></p>
            </td>
        </tr>
    </table>
</form>