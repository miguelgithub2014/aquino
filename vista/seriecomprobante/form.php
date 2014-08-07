<div class="navbar-inner">
    <br/>
        <form method="post" action="<?php if(isset ($this->action))echo $this->action ?>" id="frm">
            <input type="hidden" name="guardar" id="guardar" value="1"/>
            <input type="hidden" readonly="readonly" name="codigo" id="codigo"
                    value="<?php if(isset ($this->datos[0]['ID_SERIECOMPROBANTE']))echo $this->datos[0]['ID_SERIECOMPROBANTE']?>"/>
            <table align="center" cellpadding="10" >
                <tr>
                    <td><label>Serie:</label></td>
                    <td>
                    <input type="text" name="serie" id="serie" 
                           value="<?php if(isset ($this->datos[0]['SERIE']))echo $this->datos[0]['SERIE']?>"/></td>
                </tr>
                <tr>
                    <td><label>Max. Correlativo:</label></td>
                    <td>
                    <input type="text" name="maxcorrelativo" id="maxcorrelativo" 
                           value="<?php if(isset ($this->datos[0]['MAXCORRELATIVO']))echo $this->datos[0]['MAXCORRELATIVO']?>"/></td>
                </tr>
                <tr>
                    <td><label>Tipo Comprobante</label></td>
                    <td>
                        <select name="id_tipocomprobante" id="id_tipocomprobante">
                            <option value="0"></option>
                            <?php if($this->datos[0]['ID_TIPOCOMPROBANTE']=='1'){?>
                            <option value="1" selected="selected">TICKED SIMPLE</option>
                            <?php }else{ ?>
                            <option value="1">TICKED SIMPLE</option>
                            <?php } ?>
                            <?php if($this->datos[0]['ID_TIPOCOMPROBANTE']=='2'){?>
                            <option value="2" selected="selected">TICKED FACTURA</option>
                            <?php }else{ ?>
                            <option value="2">TICKED FACTURA</option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                    <p><button type="submit" class="btn btn-primary" id="save">Guardar</button>
                    <a href="<?php echo BASE_URL ?>seriecomprobante" class="btn btn-info">Cancelar</a></p>
                    </td>
                </tr>
            </table>
        </form>