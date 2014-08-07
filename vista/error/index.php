<table width="60%">
    <tr>
        <td>
            <img src="<?php echo BASE_URL; ?>lib/img/error.png" />
        </td>
        <td align="center">
            <h2><?php if($this->mensaje) echo $this->mensaje; ?></h2>
            <p><a href="<?php echo BASE_URL; ?>index">Ir al Inicio</a> | 
            <a href="javascript:history.back(1)">Volver a la p&aacute;gina anterior</a></p>
        </td>
    </tr>
</table>
