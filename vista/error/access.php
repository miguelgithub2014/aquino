<div class="navbar-inner text-center">
<h2><?php if ($this->mensaje) echo $this->mensaje; ?></h2>

<p><a href="<?php echo BASE_URL; ?>index">Ir al Inicio</a> | 
    <a href="javascript:history.back(1)">Volver a la p&aacute;gina anterior</a>

    <?php if (!session::get('autenticado')) { ?>

        | <a href="<?php echo BASE_URL . 'login'; ?>">Iniciar Sesi&oacute;n</a></p>

<?php } else { ?>
    </p>
<?php } ?>