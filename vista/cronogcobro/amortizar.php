<div class="navbar-inner text-center">
<form method="post" id="frm">
    <input type="hidden" name="guardar" id="guardar" value="1"/>
    <input type="hidden" id="monto_restante" value="<?php echo $this->monto_restante?>" />
<table align="center" cellpadding="10">
    <tr>
        <td><label>Fecha Pago:</label></td>
        <td>
            <input readonly="readonly" name="fecha_pago" type="text" id="fechapago" value="<?php echo date('Y-m-d')?>"/>
        </td>
    </tr>
    <tr>
        <td><label>Monto Amortizado:</label></td>
        <td>
            <input type="number" placeholder="Ingrese monto" name="monto" id="monto" value="<?php echo number_format($this->monto_restante,2) ?>"/>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <p>
                <button type="button" class="btn btn-primary" id="save">Guardar</button>
                <a href="<?php echo BASE_URL ?>cronogcobro" class="btn btn-info">Cancelar</a>
            </p>
        </td>
    </tr>
</table>
</form>