<script src="<?php echo $_params['ruta_js']; ?>bootbox.min.js"></script>
<style>
    #frm_cliente_juridico{
        display: none;
    }
</style>
<div class="navbar-inner text-center">
<?php if(isset($this->action)){?>
<table align="center" cellpadding="10">
    <tr>
        <td><label>Tipo de Cliente:</label></td>
        <td>
            <select id="tipo_cliente">
                <option value="NATURAL" selected="selected">NATURAL</option>
                <option value="JURIDICO">JURIDICO</option>
            </select>
        </td>
    </tr>
</table>
<br>
<?php } ?>
<?php if($this->datos[0]['TIPO']=='JURIDICO'){ ?>
<style>
    #frm_cliente_natural{
        display: none;
    }
    #frm_cliente_juridico{
        display: block;
    }
</style>
<?php } ?>
<?php if(isset($this->datos)) { ?>
    <h3><?php echo $this->titulo ?><span id="msg"></span></h3>
<?php } ?>
<div id="frm_cliente_natural">
    <form method="post" action="<?php if(isset ($this->action))echo $this->action ?>" id="frm_natural">
        <input type="hidden" name="guardar" id="guardar" value="1"/>
        <input type="hidden" name="tipo_cliente" value="natural"/>
        <input type="hidden" name="codigo" id="codigo"
               value="<?php if(isset ($this->datos[0]['IDCLIENTE']))echo $this->datos[0]['IDCLIENTE']?>"/>
            <table align="center" cellpadding="10">
                    <tr>
                        <td><label>Nro.Documento:</label></td>
                        <td>
                            <input class="input-large" type="text" name="documento" onKeyPress="return soloNumeros(event);"
                            maxlength="8" id="nrodoc" value="<?php if(isset ($this->datos[0]['DOCUMENTO']))echo $this->datos[0]['DOCUMENTO']?>"/>
                        </td>
                        <td><label>Nombre:</label></td>
                        <td>
                            <input type="text" name="nombres" onkeypress="return soloLetras(event)"
                            id="nombre" value="<?php if(isset ($this->datos[0]['NOMBRES']))echo $this->datos[0]['NOMBRES']?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Apellidos:</label></td>
                        <td>
                            <input type="text" name="apellidos" onkeypress="return soloLetras(event)"
                            id="apellidos" value="<?php if(isset ($this->datos[0]['APELLIDOS']))echo $this->datos[0]['APELLIDOS']?>"/>
                        <td><label>Direccion:</label></td>
                        <td>
                            <input type="text" name="direccion"
                            id="direccion" value="<?php if(isset ($this->datos[0]['DIRECCION']))echo $this->datos[0]['DIRECCION']?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Sexo:</label></td>
                        <td>
                            <style>
                                input[type="radio"]{
                                    margin: 0 2em 0 1em;
                                }
                                .input_c{
                                    display: inline-block;
                                    width: 50px;
                                }
                            </style>
                            <?php if (isset ($this->datos[0]['SEXO']) && $this->datos[0]['SEXO']==0) {?>
                            <span class="input_c"><input type="radio" name="sexo" value ="1" />M </span>
                            <span class="input_c"><input type="radio" name="sexo" value="0" checked="checked"/>F </span>
                            <?php } else { ?>
                            <span class="input_c"><input type="radio" name="sexo" value ="1" checked="checked"/>M </span>
                            <span class="input_c"><input type="radio" name="sexo" value="0" />F </span>
                            <?php } ?>
                        </td>
                        <td><label>Telefono:</label></td>
                        <td>
                            <input type="text" name="telefono" onKeyPress="return numeroTelefonico(event);"
                            id="telefono" value="<?php if(isset ($this->datos[0]['TELEFONO']))echo $this->datos[0]['TELEFONO']?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Email:</label></td>
                        <td>
                            <input type="email" name="email"
                            id="email" value="<?php if(isset ($this->datos[0]['EMAIL']))echo $this->datos[0]['EMAIL']?>"/>
                        </td>
                        <td><label>Fecha de Nacimiento:</label></td>
                        <td>
                            <input readonly="readonly" name="fecha_nacimiento" type="text"
                            id="fechanac" value="<?php echo $this->datos[0]['FECHA_NACIMIENTO'] ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Profesion:</label></td>
                        <td>
			    <select name="profesion" id="profesion" style="width: 150px">
                                <option></option>
                                <?php for($i=0;$i<count($this->datos_profesiones);$i++){ ?>
                                    <?php if( $this->datos[0]['IDPROFESION'] == $this->datos_profesiones[$i]['IDPROFESION'] ){ ?>
                                <option value="<?php echo $this->datos_profesiones[$i]['IDPROFESION'] ?>" selected="selected"><?php echo utf8_encode($this->datos_profesiones[$i]['DESCRIPCION']) ?></option>
                                    <?php } else { ?>
                                <option value="<?php echo $this->datos_profesiones[$i]['IDPROFESION'] ?>"><?php echo utf8_encode($this->datos_profesiones[$i]['DESCRIPCION']) ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </td>
                        <td><label>Estado Civil:</label></td>
                        <td>
                            <select name="estado_civil" id="estado_civil">
                                <option value="0"></option>
                                    <?php if($this->datos[0]['ESTADO_CIVIL']=='SOLTERO(A)'){?>
                                    <option value="SOLTERO(A)" selected="selected">SOLTERO(A)</option>
                                    <?php }else{ ?>
                                    <option value="SOLTERO(A)">SOLTERO(A)</option>
                                    <?php } ?>
                                    <?php if($this->datos[0]['ESTADO_CIVIL']=='CASADO(A)'){?>
                                    <option value="CASADO(A)" selected="selected">CASADO(A)</option>
                                    <?php }else{ ?>
                                    <option value="CASADO(A)">CASADO(A)</option>
                                    <?php } ?>
                                    <?php if($this->datos[0]['ESTADO_CIVIL']=='VIUDO(A)'){?>
                                    <option value="VIUDO(A)" selected="selected">VIUDO(A)</option>
                                    <?php }else{ ?>
                                    <option value="VIUDO(A)">VIUDO(A)</option>
                                    <?php } ?>
                                    <?php if($this->datos[0]['ESTADO_CIVIL']=='DIVORCIADO(A)'){?>
                                    <option value="DIVORCIADO(A)" selected="selected">DIVORCIADO(A)</option>
                                    <?php }else{ ?>
                                    <option value="DIVORCIADO(A)">DIVORCIADO(A)</option>
                                    <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Region:</label></td>
                        <td>
                <select placeholder="Seleccione..." class="regiones" id="regiones">
                    <?php if(isset ($this->datos)){ ?>
                        <?php for($i=0;$i<count($this->datos_regiones);$i++){ ?>
                            <?php if( $this->datos[0]['IDREGION'] == $this->datos_regiones[$i]['IDUBIGEO'] ){ ?>
                        <option value="<?php echo $this->datos_regiones[$i]['IDUBIGEO'] ?>" selected="selected"><?php echo $this->datos_regiones[$i]['DESCRIPCION'] ?></option>
                            <?php } else { ?>
                        <option value="<?php echo $this->datos_regiones[$i]['IDUBIGEO'] ?>"><?php echo $this->datos_regiones[$i]['DESCRIPCION'] ?></option>
                            <?php } ?>
                        <?php } ?>
                    <?php }else{ ?>
                        <?php for($i=0;$i<count($this->datos_regiones);$i++){ ?>
                            <?php if( 1901 == $this->datos_regiones[$i]['IDUBIGEO'] ){ ?>
                        <option value="<?php echo $this->datos_regiones[$i]['IDUBIGEO'] ?>" selected="selected"><?php echo $this->datos_regiones[$i]['DESCRIPCION'] ?></option>
                            <?php } else { ?>
                        <option value="<?php echo $this->datos_regiones[$i]['IDUBIGEO'] ?>"><?php echo $this->datos_regiones[$i]['DESCRIPCION'] ?></option>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                    </select></td>
                        <td><label>Provincia:</label></td>
                        <td>
                
                <select placeholder="Seleccione..." required id="provincias" name="provincias" class="comboX">
                    <option></option>
                    <?php if(isset ($this->datos)){ ?>
                        <?php for($i=0;$i<count($this->datos_provincias);$i++){ ?>
                            <?php if( $this->datos[0]['IDPROVINCIA'] == $this->datos_provincias[$i]['IDUBIGEO'] ){ ?>
                        <option value="<?php echo $this->datos_provincias[$i]['IDUBIGEO'] ?>" selected="selected"><?php echo $this->datos_provincias[$i]['DESCRIPCION'] ?></option>
                            <?php } else { ?>
                        <option value="<?php echo $this->datos_provincias[$i]['IDUBIGEO'] ?>"><?php echo $this->datos_provincias[$i]['DESCRIPCION'] ?></option>
                            <?php } ?>
                        <?php } ?>
                    <?php }else{ ?>
                        <?php for($i=0;$i<count($this->datos_provincias);$i++){ ?>
                            <?php if( 1968 == $this->datos_provincias[$i]['IDUBIGEO'] ){ ?>
                        <option value="<?php echo $this->datos_provincias[$i]['IDUBIGEO'] ?>" selected="selected"><?php echo $this->datos_provincias[$i]['DESCRIPCION'] ?></option>
                            <?php } else { ?>
                        <option value="<?php echo $this->datos_provincias[$i]['IDUBIGEO'] ?>"><?php echo $this->datos_provincias[$i]['DESCRIPCION'] ?></option>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Ciudad:</label></td>
                        <td>
                
                <select placeholder="Seleccione..." required name="ubigeo" id="ciudades" class="comboX">
                    <option></option>
                    <?php if(count($this->datos_ubigeos)){ ?>
                        <?php for($i=0;$i<count($this->datos_ubigeos);$i++){ 
                            if($i!=0){?>
                            <?php if( $this->datos[0]['IDUBIGEO'] == $this->datos_ubigeos[$i]['IDUBIGEO'] ){ ?>
                        <option value="<?php echo $this->datos_ubigeos[$i]['IDUBIGEO'] ?>" selected="selected"><?php echo $this->datos_ubigeos[$i]['DESCRIPCION'] ?></option>
                            <?php } else { ?>
                        <option value="<?php echo $this->datos_ubigeos[$i]['IDUBIGEO'] ?>"><?php echo $this->datos_ubigeos[$i]['DESCRIPCION'] ?></option>
                            <?php } ?>
                        <?php } }?>
                    <?php } ?>
                </select>
                        </td>
                    </tr>
                </table>
        <table align="center">
            <tr>
                <td align="center">
                    <p>
                        <button type="button" class="btn btn-primary" id="saveformnatural">Guardar</button>
                        <a href="<?php echo BASE_URL ?>cliente" class="btn btn-info cancel">Cancelar</a>
                    </p>
                </td>
            </tr>
        </table>
    </form>
</div>


<div id="frm_cliente_juridico">
    <form method="post" action="<?php if(isset ($this->action))echo $this->action ?>" id="frm_juridico">
        <input type="hidden" name="guardar" id="guardar" value="1"/>
        <input type="hidden" name="tipo_cliente" value="juridico"/>
        <input type="hidden" name="codigo" id="codigo"
               value="<?php if(isset ($this->datos[0]['IDCLIENTE']))echo $this->datos[0]['IDCLIENTE']?>"/>
        <div id="tabla">
        <table align="center" cellpadding="10">
            <tr>
                <td><label>Ruc:</label></td>
                <td>
                    <input type="text" name="documento" onKeyPress="return soloNumeros(event);"
                       maxlength="11" id="ruc" value="<?php if(isset ($this->datos[0]['DOCUMENTO']))echo $this->datos[0]['DOCUMENTO']?>"/>
                </td>
                <td><label>Razon Social:</label></td>
                <td>
                    <input type="text" name="nombres"
                       id="razonsocial" value="<?php if(isset ($this->datos[0]['NOMBRES']))echo $this->datos[0]['NOMBRES']?>"/>
                </td>
            </tr>
            <tr>
                <td><label>Direccion:</label></td>
                <td>
                    <input type="text" name="direccion"
                       id="direccionrs" value="<?php if(isset ($this->datos[0]['DIRECCION']))echo $this->datos[0]['DIRECCION']?>"/>
                </td>
                <td><label>Telefono:</label></td>
                <td>
                    <input type="text" onKeyPress="return numeroTelefonico(event);" name="telefono"
                       id="" value="<?php if(isset ($this->datos[0]['TELEFONO']))echo $this->datos[0]['TELEFONO']?>"/>
                </td>
            </tr>
            <tr>
                <td><label>Email:</label></td>
                <td>
                    <input type="email" name="email"
                       id="" value="<?php if(isset ($this->datos[0]['EMAIL']))echo $this->datos[0]['EMAIL']?>"/>
                </td>
                <td><label>Región:</label></td>
                <td>
                <select placeholder="Seleccione..." class="regiones ubigeojur" id="regionesjur">
                    <?php if(isset ($this->datos)){ ?>
                        <?php for($i=0;$i<count($this->datos_regiones);$i++){ ?>
                            <?php if( $this->datos[0]['IDREGION'] == $this->datos_regiones[$i]['IDUBIGEO'] ){ ?>
                        <option value="<?php echo $this->datos_regiones[$i]['IDUBIGEO'] ?>" selected="selected"><?php echo $this->datos_regiones[$i]['DESCRIPCION'] ?></option>
                            <?php } else { ?>
                        <option value="<?php echo $this->datos_regiones[$i]['IDUBIGEO'] ?>"><?php echo $this->datos_regiones[$i]['DESCRIPCION'] ?></option>
                            <?php } ?>
                        <?php } ?>
                    <?php }else{ ?>
                        <?php for($i=0;$i<count($this->datos_regiones);$i++){ ?>
                            <?php if( 1901 == $this->datos_regiones[$i]['IDUBIGEO'] ){ ?>
                        <option value="<?php echo $this->datos_regiones[$i]['IDUBIGEO'] ?>" selected="selected"><?php echo $this->datos_regiones[$i]['DESCRIPCION'] ?></option>
                            <?php } else { ?>
                        <option value="<?php echo $this->datos_regiones[$i]['IDUBIGEO'] ?>"><?php echo $this->datos_regiones[$i]['DESCRIPCION'] ?></option>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                    </select></td>
            </tr>
            <tr>
                <td><label>Provincia:</label></td>
                <td>
                <select placeholder="Seleccione..." class="ubigeojur" required id="provinciasjur" name="provincias">
                    <option></option>
                    <?php if(isset ($this->datos)){ ?>
                        <?php for($i=0;$i<count($this->datos_provincias);$i++){ ?>
                            <?php if( $this->datos[0]['IDPROVINCIA'] == $this->datos_provincias[$i]['IDUBIGEO'] ){ ?>
                        <option value="<?php echo $this->datos_provincias[$i]['IDUBIGEO'] ?>" selected="selected"><?php echo $this->datos_provincias[$i]['DESCRIPCION'] ?></option>
                            <?php } else { ?>
                        <option value="<?php echo $this->datos_provincias[$i]['IDUBIGEO'] ?>"><?php echo $this->datos_provincias[$i]['DESCRIPCION'] ?></option>
                            <?php } ?>
                        <?php } ?>
                    <?php }else{ ?>
                        <?php for($i=0;$i<count($this->datos_provincias);$i++){ ?>
                            <?php if( 1968 == $this->datos_provincias[$i]['IDUBIGEO'] ){ ?>
                        <option value="<?php echo $this->datos_provincias[$i]['IDUBIGEO'] ?>" selected="selected"><?php echo $this->datos_provincias[$i]['DESCRIPCION'] ?></option>
                            <?php } else { ?>
                        <option value="<?php echo $this->datos_provincias[$i]['IDUBIGEO'] ?>"><?php echo $this->datos_provincias[$i]['DESCRIPCION'] ?></option>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </select>
                        </td>
                <td><label>Ciudad:</label></td>
                <td>
                <select placeholder="Seleccione..." required class="ubigeojur" name="ubigeo" id="ciudadesjur">
                    <option></option>
                    <?php if(count($this->datos_ubigeos)){ ?>
                        <?php for($i=0;$i<count($this->datos_ubigeos);$i++){ 
                            if($i!=0){?>
                            <?php if( $this->datos[0]['IDUBIGEO'] == $this->datos_ubigeos[$i]['IDUBIGEO'] ){ ?>
                        <option value="<?php echo $this->datos_ubigeos[$i]['IDUBIGEO'] ?>" selected="selected"><?php echo $this->datos_ubigeos[$i]['DESCRIPCION'] ?></option>
                            <?php } else { ?>
                        <option value="<?php echo $this->datos_ubigeos[$i]['IDUBIGEO'] ?>"><?php echo $this->datos_ubigeos[$i]['DESCRIPCION'] ?></option>
                            <?php } ?>
                        <?php } } ?>
                    <?php } ?>
                </select>
                        </td>
            </tr>
            <tr>
                <td colspan="4" align="center">
                    <p>
                        <button type="button" class="btn btn-primary" id="saveformjuridico">Guardar</button>
                        <a href="<?php echo BASE_URL ?>cliente" class="btn btn-info cancel">Cancelar</a>
                    </p>
            </tr>
        </table>
        </div>
    </form>
</div>