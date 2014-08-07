 <!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
    	<meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Aquinos Gráfica Integral</title>
        <meta name="keywords" content="" />
        <meta name="description" content="" >
        <meta name="viewport" content="width=device-width">
        
        <link rel="shortcut icon" href="<?php echo BASE_URL?>lib/img/favicon.ico" type="image/x-icon" />
        
        <link href="<?php echo BASE_URL ?>lib/admin/style/bootstrap.css" rel="stylesheet" />
        <link href="<?php echo BASE_URL ?>lib/admin/style/font-awesome.css" rel="stylesheet" />
        <link href="<?php echo BASE_URL ?>lib/admin/style/style.css" rel="stylesheet" />

        
        <script src="<?php echo $_params['ruta_js']; ?>jquery.js"></script>
        <script src="<?php echo $_params['ruta_js']; ?>validaciones.js"></script>
        <script src="<?php echo $_params['ruta_js']; ?>jquery.min.js"></script>
        <script src="<?php echo $_params['ruta_js']; ?>modernizr-2.6.2.min.js"></script>
        <?php if(isset($_params['js']) && count($_params['js'])): ?>
        <?php for($i=0; $i < count($_params['js']); $i++): ?>
        
        <script src="<?php echo $_params['js'][$i] ?>" type="text/javascript"></script>
        
        <?php endfor; ?>
        <?php endif; ?>
        
        <?php if(isset($_params['css']) && count($_params['css'])): ?>
        <?php for($i=0; $i < count($_params['css']); $i++): ?>
        
        <link href="<?php echo $_params['css'][$i] ?>" type="text/css" rel="stylesheet" media="screen" />
        
        <?php endfor; ?>
        <?php endif; ?>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        <div class="navbar navbar-fixed-top bs-docs-nav" role="banner" id="headerSection">
            <div class="conjtainer">
                <div class="navbar-header">
		    <button class="navbar-toggle btn-navbar" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
			<span>Cabecera</span>
		  </button>
		</div>		
	      <!-- Navigation starts -->
	      <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">  
		  <ul class="nav navbar-nav">  
		      <!-- Upload to server link. Class "dropdown-big" creates big dropdown -->
		      <li class="dropdown dropdown-big">
			<a href="<?php echo BASE_URL ?>inicio">
			    <img src="<?php echo BASE_URL ?>lib/themes/images/pokebola.png" width="25px" alt=""/>
			    <img src="<?php echo BASE_URL ?>lib/themes/images/titulo3.png" width="180px" alt=""/>
			</a>
		      </li>
		  </ul>
		  <ul class="nav navbar-nav pull-right">
                        
