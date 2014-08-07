<style>
    #frm_cliente_juridico, #reg_clientejur{
        display: none;
    }
</style>
<script>
    $('#frm_cliente_juridico').hide();
    $('#reg_clientejur').hide();
</script>
<link href="<?php echo $_params['ruta_css']; ?>jquery-ui.custom.css" rel="stylesheet" />
<script src="<?php echo $_params['ruta_js']; ?>bootbox.min.js"></script>
<div class="navbar-inner">
    <form method="post" action="<?php if (isset($this->action)) echo $this->action ?>" id="frm">
        <input type="hidden" name="guardar" id="guardar" value="1"/>
        <input type="hidden" readonly="readonly" name="codigo" id="codigo"
               value="<?php if (isset($this->datos[0]['ID_COMPRA'])) echo $this->datos[0]['ID_COMPRA'] ?>"/>
        <table align="center" cellpadding="5" width="100%">
            <tr>
                <td colspan="2">
                    <div class="row-fluid text-right">
                        <div class="span12">
                            Nro. Doc.:
                            <input type="text" id="nrodoc" name="nrodoc" class="form-control" style="width: 150px" readonly="readonly"/>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="row-fluid">
                        <div class="span12 text-left">
                            Cliente:
                            <input type="hidden" name="aceptacredito" id="aceptacredito"/>
                            <input type="hidden" name="maximocredito" id="maximocredito"/>
                            <input type="hidden" name="id_cliente" id="id_cliente"/>
                            <input type="text" name="cliente" id="cliente" readonly="readonly" data-toggle="modal" data-target="#modalCliente" class="form-control" style="width: 210px" />
                            <button data-toggle="modal" data-target="#modalCliente" type="button" class="btn btn-sm btn-primary" title="Buscar Cliente" id="AbrirVtnBuscarCliente"><i class="icon-search icon-white"></i></button>
                            <button style="margin-right: 10px" data-toggle="modal" data-target="#modalNuevoCliente" type="button" class="btn btn-primary btn-sm" title="Insertar Cliente"><i class="icon-plus icon-white"></i></button>
                            Tipo Comprobante:
                            <select id="id_tipocomprobante" name="id_tipocomprobante" class="input-medium">
                                <option value="0"></option>
                                <option value="1">TICKED SIMPLE</option>
                                <option value="2">TICKED FACTURA</option>
                            </select>
                            Tipo Pago:
                            <select id="id_tipopago" name="id_tipopago" class="input-medium">
                                <option value="0"></option>
                                <option value="1">Contado</option>
                                <option value="2">Credito</option>
                            </select>
                        </div>
                    </div>
                </td>
            </tr>
            <tr id="celda_credito" style="display: none">
                <td colspan="2" class="text-left">
                    Fecha Final
                    <input style="margin-right: 10px" type="text" name="fecha_vencimiento" id="fecha_vencimiento" readonly="readonly" class="input-small" onchange="seleccionaDias(this)" />
                    Intervalo de Dias
                    <input type="text" name="intervalo_dias" id="intervalo_dias" class="input-small"/>
                    <input type="hidden" id="fecha_inicial" value="<?php echo date("Y-m-d") ?>" />
                </td> 
            </tr>
            <tr style="border-top: solid 1px #999">
                <td>
                    Servicio:
                    <input type="hidden" name="id_servicio" id="id_servicio"/>
                    <input type="text" name="servicio" id="servicio" readonly="readonly" placeholder="Seleccione Servicio" id="selectServicio" class="form-control"  style="width: 200px" />
                    <button type="button" class="btn btn-primary btn-sm" title="Buscar Servicio" id="AbrirVtnBuscarServicio"><i class="icon-search icon-white"></i></button>
                    <select id="id_unidadmedida" class="input-medium">
                        <option value="0">Unid. Med.:</option>
                    </select>
                    <input type="text" name="cantidad" id="cantidad" placeholder="Cantidad" class="form-control" onkeypress="return soloNumeros(event)"  style="width: 100px" />
                    <input type="text" name="precio" id="precio" placeholder="Precio" class="form-control" readonly="readonly"  style="width: 100px" />  
                    <input type="text" name="importe" id="importe" placeholder="Importe" class="form-control" readonly="readonly" style="width: 100px"/>
                    <button type="button" class="btn btn-primary btn-sm" title="Agregar al Detalle" id="addDetalle">
			<i class="icon-hand-down icon-white"></i>
		    </button>
                </td>
            </tr>
        </table>
        <table class="table table-striped table-bordered table-hover table-condensed" id="tblDetalle">
            <th>Servicio</th>
            <th>Unid. Med.</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Importe (S/.)</th>
            <th>Acciones</th>   
        </table>
        <div class="row-fluid">
            <div class="span12 text-right">
                SUBTOTAL (S/.)
                <input type="text" id="subtotal" name="subtotal" readonly="readonly" class="form-control"  style="width: 150px"/><br/>
                <input type="checkbox" id="chbx_igv" name="chbx_igv"/>
                IGV (%)
                <input type="text" id="igv" name="igv" readonly="readonly" class="form-control"  style="width: 150px"/><br/>
                TOTAL (S/.)
                <input type="text" id="total" name="total" readonly="readonly" class="form-control"  style="width: 150px"/>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12 text-center">
                <p>
                    <button type="button" class="btn btn-primary" id="save">Guardar</button>
                    <a href="<?php echo BASE_URL ?>venta" class="btn btn-info">Cancelar</a>
                </p>
            </div>
        </div>
    </form>
    <div id="modalServicio" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Lista de Servicios</h3>
        </div>
        <div class="modal-body">
            <form id="VtnBuscarServicio">
                <div class="navbar-inner text-center">
                    <p>
                        <select class="list" id="filtroServicio">
                            <option value="0">Descripcion</option>
                            <option value="1">Tipo Servicio</option>
                        </select>
                        <input type="text" class="input-xlarge" id="buscarServicio">
                        <button type="button" class="btn btn-primary" id="btn_buscarServicio"><i class="icon-search icon-white"></i></button>
                    </p>
                    <div id="grillaServicio">
                        <div class="page-header">
                            <img src="<?php echo BASE_URL ?>lib/img/loading.gif" />
                        </div>
                    </div>
                    <div id="controls">
                        <div id="perpage">
                            <select onchange="sorter.size(this.value)">
                                <option value="5">5</option>
                                <option value="10" selected="selected">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <span>Entradas por Página</span>
                        </div>
                        <div id="navigation">
                            <img src="<?php echo BASE_URL ?>lib/img/first.gif" width="16" height="16" alt="Primera Página" onclick="sorter.move(-1,true)" />
                            <img src="<?php echo BASE_URL ?>lib/img/previous.gif" width="16" height="16" alt="Página Anterior" onclick="sorter.move(-1)" />
                            <img src="<?php echo BASE_URL ?>lib/img/next.gif" width="16" height="16" alt="Página Siguiente" onclick="sorter.move(1)" />
                            <img src="<?php echo BASE_URL ?>lib/img/last.gif" width="16" height="16" alt="Última Página" onclick="sorter.move(1,true)" />
                        </div>
                        <div id="text">Página <span id="currentpage"></span> de <span id="pagelimit"></span></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        </div>
        </div>
        </div>
    </div>
    <!-- Modal -->
    <style>
        #modalCliente .modal-content,#modalServicio .modal-content,#modalNuevoCliente .modal-content{
            width: 800px;
            left: -18%;
        }
    </style>
    <div id="modalCliente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Lista de Clientees</h3>
        </div>
        <div class="modal-body">
            <form id="VtnBuscarCliente">
                <div class="navbar-inner text-center">
                    <p>
                        <select class="list" id="filtroCliente">
                            <option value="0">Nombre o Apellido / Razón Social</option>
                            <option value="1">DNI / RUC</option>
                        </select>
                        <input type="text" class="input-xlarge" id="buscarCliente">
                        <button type="button" class="btn btn-primary" id="btn_buscarCliente"><i class="icon-search icon-white"></i></button>
                    </p>
                    <div id="grillaCliente">
                        <div class="page-header">
                            <img src="<?php echo BASE_URL ?>lib/img/loading.gif" />
                        </div>
                    </div>
                    <div id="controls">
                        <div id="perpage">
                            <select onchange="sorter.size(this.value)">
                                <option value="5">5</option>
                                <option value="10" selected="selected">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <span>Entradas por Página</span>
                        </div>
                        <div id="navigation">
                            <img src="<?php echo BASE_URL ?>lib/img/first.gif" width="16" height="16" alt="Primera Página" onclick="sorter.move(-1,true)" />
                            <img src="<?php echo BASE_URL ?>lib/img/previous.gif" width="16" height="16" alt="Página Anterior" onclick="sorter.move(-1)" />
                            <img src="<?php echo BASE_URL ?>lib/img/next.gif" width="16" height="16" alt="Página Siguiente" onclick="sorter.move(1)" />
                            <img src="<?php echo BASE_URL ?>lib/img/last.gif" width="16" height="16" alt="Última Página" onclick="sorter.move(1,true)" />
                        </div>
                        <div id="text">Página <span id="currentpage"></span> de <span id="pagelimit"></span></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        </div>
        </div>
        </div>
    </div>
    <div id="modalNuevoCliente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Registrar Cliente</h3>
        </div>
        <div class="modal-body">
            <form method="post" action="" id="frm">
                <input type="hidden" name="guardar" id="guardar" value="1"/>
                <table align="center" cellpadding="5">
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
                            maxlength="8" id="dni" value="<?php if(isset ($this->datos[0]['DOCUMENTO']))echo $this->datos[0]['DOCUMENTO']?>"/>
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
                                    margin: 0 0.5em 0 1.5em;
                                }
                            </style>
                            <?php if (isset ($this->datos[0]['SEXO']) && $this->datos[0]['SEXO']==0) {?>
                            <input type="radio" name="sexo" value ="1" />M
                            <input type="radio" name="sexo" value="0" checked="checked"/>F
                            <?php } else { ?>
                            <input type="radio" name="sexo" value ="1" checked="checked"/>M
                            <input type="radio" name="sexo" value="0" />F
                            <?php } ?>
                        </td>
                        <td><label>Telefono:</label></td>
                        <td>
                            <input type="text" name="telefono" onKeyPress="return numeroTelefonico(event);"
                            id="telefononat" value="<?php if(isset ($this->datos[0]['TELEFONO']))echo $this->datos[0]['TELEFONO']?>"/>
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
                       id="telefonors" value="<?php if(isset ($this->datos[0]['TELEFONO']))echo $this->datos[0]['TELEFONO']?>"/>
                </td>
            </tr>
            <tr>
                <td><label>Email:</label></td>
                <td>
                    <input type="email" name="email"
                       id="emailrs" value="<?php if(isset ($this->datos[0]['EMAIL']))echo $this->datos[0]['EMAIL']?>"/>
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
        </table>
        </div>
    </form>
</div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="reg_clientenat">Registrar Cliente Natural</button>
            <button type="button" class="btn btn-primary" id="reg_clientejur">Registrar Cliente Juridico</button>
            <button class="btn btn-info" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        </div>
        </div>
        </div>
    </div>
    