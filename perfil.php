                        <li class="orange user-profile">
                            <a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle" style="color: #ddd">
                                <i class="icon-user"></i>
                                <span id="user_info">
                                    <small>Bienvenido,</small>
                                    <?php echo session::get('perfil')?> <?php echo session::get('empleado')?>
                                    | <?php echo Main::get_servidor() ?>
                                </span>

                                <i class="icon-caret-down"></i>
                            </a>

                            <ul class="pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer" id="user_menu">
                                <li>
                                    <a href="<?php echo BASE_URL?>login/cerrar">
                                        <i class="icon-off"></i>
                                        Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav><!--/.container-fluid-->
            </div><!--/.navbar-inner-->
        </div>
    <div class="content" id="cuerpo">
	<div class="sidebar">
	    <div class="sidebar-dropdown"><a href="#">Menú</a></div>
            <script>
                var url="<?php echo BASE_URL ?>";
            </script>