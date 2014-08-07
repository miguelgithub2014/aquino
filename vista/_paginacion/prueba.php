<?php if(isset($this->_paginacion)): ?>
<?php if($this->_paginacion['primero']): ?>
    <a href="<?php echo $link . $this->_paginacion['primero']; ?>" class="button">Primero</a>
<?php else:?>
    <span class="disable">Primero</span>
<?php endif; ?>
    &nbsp;
<?php if($this->_paginacion['anterior']): ?>
    <a href="<?php echo $link . $this->_paginacion['anterior']; ?>" class="button">Anterior</a>
<?php else:?>
    <span class="disable">Anterior</span>
<?php endif; ?>
    &nbsp;
<?php for($i = 0; $i < count($this->_paginacion['rango']); $i++):?>
    <?php if($this->_paginacion['actual'] == $this->_paginacion['rango'][$i]): ?>
        <span class="disable"><?php echo $this->_paginacion['rango'][$i]; ?></span>
    <?php else:?>
        <a href="<?php echo $link . $this->_paginacion['rango'][$i]; ?>" class="button">
            <?php echo $this->_paginacion['rango'][$i]; ?>
        </a>&nbsp;
    <?php endif; ?>
<?php endfor;?>
    &nbsp;
<?php if($this->_paginacion['siguiente']): ?>
    <a href="<?php echo $link . $this->_paginacion['siguiente']; ?>" class="button">Siguiente</a>
<?php else:?>
    <span class="disable">Siguiente</span>
<?php endif; ?>
    &nbsp;
<?php if($this->_paginacion['ultimo']): ?>
    <a href="<?php echo $link . $this->_paginacion['ultimo']; ?>" class="button">Ultimo</a>
<?php else:?>
    <span class="disable">Ultimo</span>
<?php endif; ?>
<?php endif; ?>
