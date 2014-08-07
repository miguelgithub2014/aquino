<script src="<?php echo $_params['ruta_js']; ?>bootbox.min.js"></script>
<div class="navbar-inner">
    <form method="post" action="<?php if(isset ($this->action))echo $this->action ?>" id="frm">
    <input type="hidden" name="guardar" id="guardar" value="1"/>
    <input type="hidden" readonly="readonly" name="codigo" id="codigo"
                value="<?php if(isset ($this->datos[0]['ID_PROVEEDOR']))echo $this->datos[0]['ID_PROVEEDOR']?>"/>
    <table align="center" cellpadding="10">
        <tr>
            <td><label>Razon Social:</label></td>
            <td><input type="text" name="razonsocial" id="razonsocial" 
               value="<?php if(isset ($this->datos[0]['RAZONSOCIAL']))echo $this->datos[0]['RAZONSOCIAL']?>"/></td>
        </tr>
        <tr>
            <td><label>Representante:</label></td>
            <td><input type="text" name="nombre" onkeypress="return soloLetras(event)"
               id="nombre" value="<?php if(isset ($this->datos[0]['NOMBRE']))echo $this->datos[0]['NOMBRE']?>"/></td>
        </tr>
        <tr>
            <td><label>RUC:</label></td>
            <td><input type="text" name="ruc" id="ruc" maxlength="11" onkeypress="return soloNumeros(event)"
               value="<?php if(isset ($this->datos[0]['RUC']))echo $this->datos[0]['RUC']?>"/></td>
        </tr>
        <tr>
            <td><label>Direccion:</label></td>
            <td><input type="text" name="direccion"
               id="direccion" value="<?php if(isset ($this->datos[0]['DIRECCION']))echo $this->datos[0]['DIRECCION']?>"/></td>
        </tr>
        <tr>
            <td><label>Telefono:</label></td>
            <td><input type="text" name="telefmovil" id="telefmovil" onkeypress="return numeroTelefonico(event)"
               value="<?php if(isset ($this->datos[0]['TELEFMOVIL']))echo $this->datos[0]['TELEFMOVIL']?>"/></td>
        </tr>
        <tr>
            <td><label>Email:</label></td>
            <td><input type="text" name="email" id="email"
               value="<?php if(isset ($this->datos[0]['EMAIL']))echo $this->datos[0]['EMAIL']?>"/></td>
        </tr>
        <tr>
            <td><label>Ciudad:</label></td>
            <td><input type="text" name="ciudad" id="ciudad" 
               value="<?php if(isset ($this->datos[0]['CIUDAD']))echo $this->datos[0]['CIUDAD']?>"/></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <p><button type="submit" class="btn btn-primary" id="save">Guardar</button>
                <a href="<?php echo BASE_URL ?>proveedor" class="btn btn-info">Cancelar</a></p>
            </td>
        </tr>
    </table>
</form>