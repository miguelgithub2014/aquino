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
                            <input type="text" id="nrodoc" name="nrodoc" class="form-control" maxlength="11" style="margin-right: 1em; width: 120px" />
                            Fecha:
                            <input type="text" id="fechacompra" name="fechacompra" readonly="readonly" class="form-control"  style="width: 100px" />
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="row-fluid">
                        <div class="span12 text-left">
                            Proveedor:
                            <input type="hidden" name="id_proveedor" id="id_proveedor"/>
                            <input type="text" name="proveedor" id="proveedor" readonly="readonly" data-toggle="modal" data-target="#modalProveedor" class="form-control"  style="width: 200px" />
                            <button data-toggle="modal" data-target="#modalProveedor" type="button" class="btn btn-primary btn-sm" title="Buscar Proveedor" id="AbrirVtnBuscarProveedor"><i class="icon-search icon-white"></i></button>
                            <button style="margin-right: 10px" data-toggle="modal" data-target="#modalNuevoProveedor" type="button" class="btn btn-primary btn-sm" title="Insertar Proveedor"><i class="icon-plus icon-white"></i></button>
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
                    <input style="margin-right: 10px" type="text" name="fecha_vencimiento" id="fecha_vencimiento" readonly="readonly" class="input-small" onchange="seleccionaDias(this)"/>
                    Intervalo de Dias
                    <input type="text" name="intervalo_dias" id="intervalo_dias" class="input-small"/>
                </td> 
            </tr>
            <tr style="border-top: solid 1px #999">
                <td>
                    Insumo:
                    <input type="hidden" name="id_insumo" id="id_insumo"/>
                    <input type="hidden" name="stockactual" id="stockactual"/>
                    <input type="text" name="insumo" id="insumo" readonly="readonly" placeholder="Seleccione Insumo" id="selectInsumo" data-toggle="modal" data-target="#modalInsumo" class="form-control"  style="width: 200px"/>
                    <button type="button" data-toggle="modal" data-target="#modalInsumo" class="btn btn-primary btn-sm" title="Buscar Insumo" id="AbrirVtnBuscarInsumo"><i class="icon-search icon-white"></i></button>
                    <select id="id_unidadmedida" class="input-medium">
                        <option value="0">Unid. Med.:</option>
                    </select>
                    <input type="text" name="cantidadum" id="cantidadum" placeholder="Cantidad" class="form-control" onkeypress="return soloNumeros(event)" style="width: 100px" />
                    <input type="hidden" name="cantidadub" id="cantidadub" placeholder="Cantidad UB"/>
                    <input type="hidden" name="precioub" id="precioub" />
                    <input type="text" name="preciounitario" id="preciounitario" placeholder="PUxUM" class="form-control" style="width: 100px" />  
                    <input type="text" name="importe" id="importe" placeholder="Importe" class="form-control" readonly="readonly" style="width: 100px" />
                    <button type="button" class="btn btn-primary btn-sm" title="Agregar al Detalle" id="addDetalle"><i class="icon-hand-down icon-white"></i></button>
                </td>
            </tr>
        </table>
        <table class="table table-striped table-bordered table-hover table-condensed" id="tblDetalle">
            <th>Insumo</th>
            <th>Unid. Med.</th>
            <th>Cantidad</th>
            <th>PUxUM (S/.)</th>
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
                    <a href="<?php echo BASE_URL ?>compra" class="btn btn-info">Cancelar</a>
                </p>
            </div>
        </div>
    </form>
    <div id="modalInsumo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Lista de Insumos</h3>
        </div>
        <div class="modal-body">
            <form id="VtnBuscarInsumo">
                <div class="navbar-inner text-center">
                    <p>
                        <select class="list" id="filtroInsumo">
                            <option value="0">Descripcion</option>
                            <option value="1">Almacen</option>
                        </select>
                        <input type="text" class="input-xlarge" id="buscarInsumo">
                        <button type="button" class="btn btn-primary" id="btn_buscarInsumo"><i class="icon-search icon-white"></i></button>
                    </p>
                    <div id="grillaInsumo">
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
        #modalProveedor .modal-content,#modalInsumo .modal-content {
            width: 800px;
            left: -18%;
        }
    </style>
    <div id="modalProveedor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Lista de Proveedores</h3>
        </div>
        <div class="modal-body">
            <form id="VtnBuscarProveedor">
                <div class="navbar-inner text-center">
                    <p>
                        <select class="list" id="filtroProveedor">
                            <option value="0">Razon Social</option>
                            <option value="1">Representante</option>
                            <option value="2">RUC</option>
                        </select>
                        <input type="text" class="input-xlarge" id="buscarProveedor">
                        <button type="button" class="btn btn-primary" id="btn_buscarProveedor"><i class="icon-search icon-white"></i></button>
                    </p>
                    <div id="grillaProveedor">
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
    
    <div id="modalNuevoProveedor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Registrar Proveedor</h3>
        </div>
        <div class="modal-body">
            <form method="post" action="" id="frm">
                <input type="hidden" name="guardar" id="guardar" value="1"/>
                <table align="center" cellpadding="5">
                    <tr>
                        <td><label>Razon Social:</label></td>
                        <td><input type="text" name="razonsocialprov" id="razonsocialprov" /></td>
                    </tr>
                    <tr>
                        <td><label>Representante:</label></td>
                        <td><input type="text" name="nombreprov" id="nombreprov" onkeypress="return soloLetras(event)" /></td>
                    </tr>
                    <tr>
                        <td><label>RUC:</label></td>
                        <td><input type="text" name="rucprov" id="rucprov" maxlength="11" onkeypress="return soloNumeros(event)"/></td>
                    </tr>
                    <tr>
                        <td><label>Direccion:</label></td>
                        <td><input type="text" name="direccionprov" id="direccionprov" /></td>
                    </tr>
                    <tr>
                        <td><label>Telefono:</label></td>
                        <td><input type="text" name="telefmovilprov" id="telefmovilprov" onkeypress="return numeroTelefonico(event)"/></td>
                    </tr>
                    <tr>
                        <td><label>Email:</label></td>
                        <td><input type="email" name="emailprov" id="emailprov" /></td>
                    </tr>
                    <tr>
                        <td><label>Ciudad:</label></td>
                        <td><input type="text" name="ciudadprov" id="ciudadprov" /></td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="reg_proveedor">Registrar Proveedor</button>
            <button class="btn btn-info" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        </div>
        </div>
        </div>
    </div>
    