<div class="navbar-inner">
        <form method="post" action="<?php if(isset ($this->action))echo $this->action ?>" id="frm">
            <input type="hidden" name="guardar" id="guardar" value="1"/>
            <input type="hidden" readonly="readonly" name="codigo" id="codigo"
                    value="<?php if(isset ($this->datos[0]['ID_SERVICIO']))echo $this->datos[0]['ID_SERVICIO']?>"/>
            <table align="center" cellpadding="10" >
                <tr>
                    <td><label>Descripcion</label></td>
                    <td>
                    <input type="text" name="descripcion" onkeypress="return soloLetras(event)"
                            id="descripcion" value="<?php if(isset ($this->datos[0]['DESCRIPCION']))echo $this->datos[0]['DESCRIPCION']?>"/></td>
                </tr>
                <tr>
                    <td><label>Tipo Servicio</label></td>
                    <td>
                        <select name="id_tiposervicio" id="id_tiposervicio">
                            <option value="0"></option>
                            <?php for($i=0;$i<count($this->datos_tiposervicio);$i++){ ?>
                                <?php if( $this->datos[0]['ID_TIPOSERVICIO'] == $this->datos_tiposervicio[$i]['ID_TIPOSERVICIO'] ){ ?>
                            <option value="<?php echo $this->datos_tiposervicio[$i]['ID_TIPOSERVICIO'] ?>" selected="selected"><?php echo $this->datos_tiposervicio[$i]['DESCRIPCION'] ?></option>
                                <?php } else { ?>
                            <option value="<?php echo $this->datos_tiposervicio[$i]['ID_TIPOSERVICIO'] ?>"><?php echo $this->datos_tiposervicio[$i]['DESCRIPCION'] ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                    <p><button type="button" class="btn btn-primary" id="save">Guardar</button>
                    <a href="<?php echo BASE_URL ?>servicio" class="btn btn-info">Cancelar</a></p>
                    </td>
                </tr>
            </table>
        </form>