<link href="<?php echo $_params['ruta_css']; ?>jquery-ui.custom.css" rel="stylesheet" />
<script src="<?php echo $_params['ruta_js']; ?>bootbox.min.js"></script>
<div class="navbar-inner">
    <form method="post" action="<?php if (isset($this->action)) echo $this->action ?>" id="frm">
        <input type="hidden" name="guardar" id="guardar" value="1"/>
        <input type="hidden" readonly="readonly" name="codigo" id="codigo"
               value="<?php if (isset($this->datos[0]['ID_PRODUCCION'])) echo $this->datos[0]['ID_PRODUCCION'] ?>"/>
        <table align="center" cellpadding="5" width="100%">
            <tr>
                <td colspan="2">
                    <div class="row-fluid">
                        <div class="span12 text-left">
                            Empleado:
                            <input type="hidden" name="id_empleado" id="id_empleado"/>
                            <input type="text" name="empleado" id="empleado" readonly="readonly" data-toggle="modal" data-target="#modalEmpleado"/>
                            <button style="margin-top:-10px" data-toggle="modal" data-target="#modalEmpleado" type="button" class="btn btn-primary" title="Buscar Empleado" id="AbrirVtnBuscarEmpleado"><i class="icon-search icon-white"></i></button>
                            
                            Venta:
                            <input type="hidden" name="id_venta" id="id_venta"/>
                            <input type="text" name="venta" id="venta" readonly="readonly" data-toggle="modal" data-target="#modalVenta"/>
                            <button style="margin-top:-10px" data-toggle="modal" data-target="#modalVenta" type="button" class="btn btn-primary" title="Buscar Venta" id="AbrirVtnBuscarVenta"><i class="icon-search icon-white"></i></button>
                            
                            Fecha Programada:
                            <input type="text" id="fecha_programada" name="fecha_programada" readonly="readonly" class="input-small"/>
                        </div>
                    </div>
                </td>
            </tr>
            <tr style="border-top: solid 1px #999">
                <td>
                    Insumo:
                    <input type="hidden" name="id_insumo" id="id_insumo"/>
                    <input type="hidden" name="stockactual" id="stockactual"/>
                    <input type="text" name="insumo" id="insumo" readonly="readonly" placeholder="Seleccione Insumo" id="selectInsumo" data-toggle="modal" data-target="#modalInsumo"/>
                    <button type="button" data-toggle="modal" data-target="#modalInsumo" style="margin-top: -10px" class="btn btn-primary" title="Buscar Insumo" id="AbrirVtnBuscarInsumo"><i class="icon-search icon-white"></i></button>
                    <select id="id_unidadmedida" class="input-medium">
                        <option value="0">Unid. Med.:</option>
                    </select>
                    <input type="text" name="cantidadum" id="cantidadum" placeholder="Cantidad" class="input-small" onkeypress="return soloNumeros(event)"/>
                    <input type="hidden" name="cantidadub" id="cantidadub" placeholder="Cantidad UB"/>
                    <button style="margin-top: -10px" type="button" class="btn btn-primary" title="Agregar al Detalle" id="addDetalle"><i class="icon-hand-down icon-white"></i></button>
                </td>
            </tr>
        </table>
        <table class="table table-striped table-bordered table-hover table-condensed" id="tblDetalle">
            <th>Insumo</th>
            <th>Unid. Med.</th>
            <th>Cantidad</th>
            <th>Acciones</th>   
        </table>
        <div class="row-fluid">
            <div class="span12 text-center">
                <p>
                    <button type="button" class="btn btn-primary" id="save">Guardar</button>
                    <a href="<?php echo BASE_URL ?>produccion" class="btn btn-info">Cancelar</a>
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
        #modalEmpleado .modal-content,#modalInsumo .modal-content,#modalVenta .modal-content {
            width: 800px;
            left: -18%;
        }
    </style>
    <div id="modalEmpleado" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Lista de Empleadoes</h3>
        </div>
        <div class="modal-body">
            <form id="VtnBuscarEmpleado">
                <div class="navbar-inner text-center">
                    <p>
                        <select class="list" id="filtroEmpleado">
                            <option value="0">Nombres</option>
                            <option value="1">Apellidos</option>
                            <option value="2">Usuario</option>
                            <option value="3">Perfil</option>
                        </select>
                        <input type="text" class="input-xlarge" id="buscarEmpleado">
                        <button type="button" class="btn btn-primary" id="btn_buscarEmpleado"><i class="icon-search icon-white"></i></button>
                    </p>
                    <div id="grillaEmpleado">
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
    
    
    <div id="modalVenta" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Lista de Ventas</h3>
        </div>
        <div class="modal-body">
            <form id="VtnBuscarVenta">
                <div class="navbar-inner text-center">
                    <p>
                        <select class="list" id="filtroVenta">
                            <option value="0">Nro Doc.</option>
                            <option value="1">Cliente</option>
                            <option value="2">Empleado</option>
                        </select>
                        <input type="text" class="input-xlarge" id="buscarVenta">
                        <button type="button" class="btn btn-primary" id="btn_buscarVenta"><i class="icon-search icon-white"></i></button>
                    </p>
                    <div id="grillaVenta">
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
    