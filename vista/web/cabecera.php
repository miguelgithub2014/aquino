<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>AQUINOS Gráfica Integral</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" >
    <meta name="viewport" content="width=device-width">
    
    <link rel="shortcut icon" href="<?php echo BASE_URL?>lib/img/favicon.ico" type="image/x-icon" />
    
    <link id="callCss" rel="stylesheet" href="<?php echo BASE_URL ?>lib/themes/current/bootstrap.min.css" type="text/css" media="screen"/>
    <link href="<?php echo BASE_URL ?>lib/themes/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URL ?>lib/themes/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URL ?>lib/themes/css/base.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URL ?>lib/css/jquery.motionCaptcha.css" rel="stylesheet" />
        
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo $_params['ruta_js']; ?>jquery.js"></script>
    <script src="<?php echo $_params['ruta_js']; ?>modernizr-2.6.2.min.js"></script>
    <script src="<?php echo $_params['ruta_js']; ?>validaciones.js"></script>
</head>
<body>
<section id="header">
    <div class="container">
	<div id="logoArea" class="navbar" style="margin-bottom: 0">
	    <a id="smallScreen" data-target="#topMenu" data-toggle="collapse" class="btn btn-navbar">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	    </a>
	    <div class="navbar-inner">
		<a class="brand" href="<?php echo BASE_URL ?>">
		    <img src="<?php echo BASE_URL ?>lib/themes/images/pokebola.png" width="50px" alt=""/>
		    <img src="<?php echo BASE_URL ?>lib/themes/images/titulo3.png" height="40px" alt=""/>
		</a>
		<ul id="topMenu" class="nav pull-right">
		     <li class="li_index"><a href="<?php echo BASE_URL ?>">Inicio</a></li>
		     <li class="li_nosotros"><a href="<?php echo BASE_URL ?>web/nosotros">Nosotros</a></li>
		     <li class="li_servicios"><a href="<?php echo BASE_URL ?>web/servicios">Servicios</a></li>
		     <li class="li_clientes"><a href="<?php echo BASE_URL ?>web/clientes">Clientes</a></li>
		     <li class="li_contactenos"><a href="<?php echo BASE_URL ?>web/contactenos">Contáctenos</a></li>
		     <li>
			 <?php if(session::get('autenticado')){ ?>
			    <a href="<?php echo BASE_URL ?>inicio">Sistema</a>
			<?php }else{ ?>
			 <a href="#myModal" role="button" data-toggle="modal" style="padding-right:0">
			     <span class="btn btn-warning">Login</span>
			 </a>
			<?php } ?>
		    </li>
	    </ul>
	</div>
	</div>
    </div>
</section>
<div class="container" id="div_contenido_body">
    <div class="navbar-inner"><br/>