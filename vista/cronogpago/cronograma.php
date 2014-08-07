<div class="navbar-inner text-center">
<p><a type="button" class="btn btn-info" href="<?php echo $this->btn_action ?>">Amortizar</a></p><br/>
<table id="table" class="table table-striped table-bordered table-hover sortable">
    <tr>
        <th>Nro Cuota</th>
        <th>Fecha de Pago</th>
        <th>Monto de Cuota</th>
        <th>Monto Pagado</th>
        <th>Estado</th>
    </tr>
    <?php for($i=0;$i<count($this->datos);$i++){ ?>
    <tr>
        <td><?php echo $this->datos[$i]['NROCUOTA']?></td>
        <td><?php echo $this->datos[$i]['FECHA']?></td>
        <td><?php echo $this->datos[$i]['MONTO_CUOTA']?></td>
        <td><?php echo $this->datos[$i]['MONTO_PAGADO']?></td>
        <td>
            <?php 
            if($this->datos[$i]['MONTO_CUOTA'] ==$this->datos[$i]['MONTO_PAGADO']){
                echo 'cancelado';
            }else{
                if(new DateTime($this->datos[$i]['FECHA'],new DateTimeZone('America/Lima'))>new DateTime(date("M d Y"),new DateTimeZone('America/Lima')) && $this->datos[$i]['MONTO_CUOTA'] > $this->datos[$i]['MONTO_PAGADO']){
//                if(strtotime(str_replace('/', '-', $this->datos[$i]['FECHA']))>strtotime('now') && $this->datos[$i]['MONTO_CUOTA'] > $this->datos[$i]['MONTO_PAGADO']){
                    echo 'normal';
                }else{
                    echo 'vencido';
                }
            }
            ?>
        </td>
    </tr>
    <?php } ?>
</table>
<p><a href="<?php echo BASE_URL?>cronogpago" class="btn btn-primary">Aceptar</a></p>
<br/>
