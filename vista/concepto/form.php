<div class="navbar-inner">
        <form method="post" action="<?php if(isset ($this->action))echo $this->action ?>" id="frm">
            <input type="hidden" name="guardar" id="guardar" value="1"/>
            <input type="hidden" readonly="readonly" name="codigo" id="codigo"
                    value="<?php if(isset ($this->datos[0]['ID_CONCEPTO']))echo $this->datos[0]['ID_CONCEPTO']?>"/>
            <table align="center" cellpadding="10" >
                <tr>
                    <td><label>Descripcion</label></td>
                    <td>
                    <input type="text" name="descripcion" onkeypress="return soloLetras(event)"
                            id="descripcion" value="<?php if(isset ($this->datos[0]['DESCRIPCION']))echo $this->datos[0]['DESCRIPCION']?>"/></td>
                </tr>
                <tr>
                    <td><label>Tipo Concepto</label></td>
                    <td>
                        <select name="id_tipoconcepto" id="id_tipoconcepto">
                            <option value="0"></option>
                            <?php for($i=0;$i<count($this->datos_tipoconcepto);$i++){ ?>
                                <?php if( $this->datos[0]['ID_TIPOCONCEPTO'] == $this->datos_tipoconcepto[$i]['ID_TIPOCONCEPTO'] ){ ?>
                            <option value="<?php echo $this->datos_tipoconcepto[$i]['ID_TIPOCONCEPTO'] ?>" selected="selected"><?php echo utf8_encode($this->datos_tipoconcepto[$i]['DESCRIPCION']) ?></option>
                                <?php } else { ?>
                            <option value="<?php echo $this->datos_tipoconcepto[$i]['ID_TIPOCONCEPTO'] ?>"><?php echo utf8_encode($this->datos_tipoconcepto[$i]['DESCRIPCION']) ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                    <p><button type="button" class="btn btn-primary" id="save">Guardar</button>
                    <a href="<?php echo BASE_URL ?>concepto" class="btn btn-info">Cancelar</a></p>
                    </td>
                </tr>
            </table>
        </form>