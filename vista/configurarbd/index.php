<div class="navbar-inner">
<form method="post" action="<?php if(isset ($this->action))echo $this->action ?>" id="frm">
    <input type="hidden" name="guardar" id="guardar" value="1"/>
    <table align="center" cellpadding="10" >
        <caption><span id="msg"></span></caption>
        <tr>
            <td><label>SGBD: </label></td>
            <td>
                <select name="sgbd" id="sgbd">
                    <option></option>
                    <option value="mysql">MySQL</option>            
                    <option value="pgsql">PostgreSQL</option>            
                    <option value="mssql">SQL Server</option>            
                    <option value="oci">Oracle</option>            
                </select>
            </td>
        </tr>
        <tr>
            <td><label>Usuario: </label></td>
            <td><input type="text" name="usuario" id="usuario" value="" /></td>
        </tr>
        <tr>
            <td><label>Clave: </label></td>
            <td><input type="password" name="clave" id="clave" value="" /></td>
        </tr>
        <tr>
            <td><label>Host: </label></td>
            <td><input type="text" name="host" id="host" value="" /></td>
        </tr>
        <tr>
            <td><label>Puerto: </label></td>
            <td><input type="text" name="puerto" id="puerto" value="" /></td>
        </tr>
        <tr>
            <td><label>Base de Datos: </label></td>
            <td><input type="text" name="basedatos" id="basedatos" value="" /></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <p><button type="submit" id="save" class="btn btn-primary">Guardar</button>
                <a href="<?php echo BASE_URL ?>" class="btn btn-info">Cancelar</a></p>
            </td>
        </tr>
    </table>
</form>
