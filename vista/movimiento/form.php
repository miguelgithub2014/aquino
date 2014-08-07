<div class="navbar-inner">
<form method="post" action="<?php if(isset ($this->action))echo $this->action ?>" id="frm">
    <input type="hidden" name="guardar" id="guardar" value="1"/>
    <table align="center" cellpadding="10" >
        <tr>
            <td><label>Tipo Concepto:</label></td>
            <td>
                <select name="id_tipoconcepto" id="id_tipoconcepto">
                    <option value="0">&nbsp;</option>
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
            <td><label>Concepto Movimiento:</label></td>
            <td>
                <select name="concepto" id="concepto">
                    <option value="0"></option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label>Referencia:</label></td>
            <td><textarea id="referencia" name="referencia" cols="30" rows="8" style="width: 300px;height:100px"></textarea>
            </td>
        </tr>
        <tr id="celda_formapago" style="display: none">
            <td><label>Forma de Pago:</label></td>
            <td>
                <select name="id_formapago" id="id_formapago">
                    <option value="0"></option>
                    <option value="1">Efectivo</option>
                    <option value="2">Tarjeta</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label>Monto:</label></td>
            <td><input type="text" name="monto" id="monto" placeholder="Ingrese Monto" value=""/>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <p><button type="button" class="btn btn-primary" id="save">Guardar</button>
                <a href="<?php echo BASE_URL ?>movimiento" class="btn btn-info">Cancelar</a></p>
            </td>
        </tr>
    </table>
</form>