<div class="navbar-inner">
<form method="post" action="<?php if(isset ($this->action))echo $this->action ?>" id="frm">
    <input type="hidden" name="guardar" id="guardar" value="1"/>
    <table align="center" cellpadding="10" width="100%" >
        <tr>
            <td>
                <div class="row text-center">
                    <div class="col-md-4">
                        Quienes Somos<br>
                        <textarea name="conocenos" rows="10" class="form-control" id="conocenos"><?php if(isset ($this->datos[0]['CONOCENOS']))echo $this->datos[0]['CONOCENOS']?></textarea>
                    </div>
                    <div class="col-md-4">
                        Misión<br>
                        <textarea name="mision" rows="10" class="form-control" id="mision"><?php if(isset ($this->datos[0]['MISION']))echo $this->datos[0]['MISION']?></textarea>
                    </div>
                    <div class="col-md-4">
                        Visión<br>
                        <textarea name="vision" rows="10" class="form-control" id="vision"><?php if(isset ($this->datos[0]['VISION']))echo $this->datos[0]['VISION']?></textarea>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="text-center">
            <p><button type="button" class="btn btn-primary" id="save">Guardar</button>
            <a href="<?php echo BASE_URL ?>informacion" class="btn btn-info">Cancelar</a></p>
            </td>
        </tr>
    </table>
</form>
