<div class="navbar-inner">
        <form method="post" action="<?php if(isset ($this->action))echo $this->action ?>" id="frm">
            <input type="hidden" name="guardar" id="guardar" value="1"/>
            <table align="center" cellpadding="10" >
                <tr>
                    <td><label>Codigo</label></td>
                    <td>
                    <input type="text" name="id_param" id="id_param" 
                           <?php if(isset ($this->datos[0]['ID_PARAM']))echo "value=".$this->datos[0]['ID_PARAM']. " readonly='readonly'" ?>/>
                    </td>
                </tr>
                <tr>
                    <td><label>Valor</label></td>
                    <td>
                    <input type="text" name="valor" id="valor" 
                           value="<?php if(isset ($this->datos[0]['VALOR']))echo $this->datos[0]['VALOR']?>"/>
                    </td>
                </tr>
                <tr>
                    <td><label>Descripcion</label></td>
                    <td>
                    <input type="text" name="descripcion" id="descripcion" 
                           value="<?php if(isset ($this->datos[0]['DESCRIPCION']))echo $this->datos[0]['DESCRIPCION']?>"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                    <p><button type="submit" class="btn btn-primary" id="save">Guardar</button>
                    <a href="<?php echo BASE_URL ?>param" class="btn btn-info">Cancelar</a></p>
                    </td>
                </tr>
            </table>
        </form>