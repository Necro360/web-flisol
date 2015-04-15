<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	
	<title>Registro - FLISoL Aragón 2015</title>
	<meta name="description" content="Página de registro a talleres del FLISoL Aragón 2015.">
	
	<!-- Mobile viewport optimized: h5bp.com/viewport -->
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	
	<link rel="stylesheet" media="screen" href="css/superfish.css" /> 
	<link rel="stylesheet" href="css/nivo-slider.css" media="all"  /> 
	<link rel="stylesheet" href="css/tweet.css" media="all"  />
	<link rel="stylesheet" href="/css/material/base.min.css" />
	<link rel="stylesheet" media="all" href="css/lessframework.css"/>
</head>
<body class="page-blue">

	<!-- Encabezado y barra de navegación. -->
	<?php include 'encabeza.php'; ?>
	<!-- FIN Encabezado, barra navegación -->
	
	
	<!-- Contenido principal -->
	<div class="content">
		<div class="content-heading">
			<div class="container">
				<h3>Regístrate a nuestros talleres</h3>
			</div>
		</div>

		<div class="content-inner">
			<div class="container">
				<form class="form" id="contactForm" action="#" method="post">
					<fieldset>
						<legend>Registro</legend>

						<p>Si ya registraste un taller, solo deberás introducir tu correo y el taller que deseas inscribir.</p>

						<div class="form-group form-group-label control-highlight">
							<div class="row">
								<div class="col-lg-6 col-sm-8">
									<label class="floating-label" for="correo">Email</label>
									<input name="correo" id="float-text" type="text" class="form-control" />
								</div>
							</div>
						</div>

						<div class="form-group form-group-label control-highlight">
							<div class="row">
								<div class="col-lg-6 col-sm-8">
									<label class="floating-label" for="nombre">Nombre</label>
									<input class="form-control" id="float-text" name="nombre" type="text" />
								</div>
							</div>
						</div>

						<div class="form-group form-group-label control-highlight">
							<div class="row">
								<div class="col-lg-6 col-sm-8">
									<label class="floating-label" for="apellidos">Apellidos</label>
									<input class="form-control" id="float-text" name="apellidos" type="text" />
								</div>
							</div>
						</div>
						
						<div class="form-group form-group-label control-highlight">
							<div class="row">
								<div class="col-lg-6 col-sm-8">
									<label class="floating-label" for="universidad">Institución</label>
									<input class="form-control" name="universidad"  id="float-text" type="text" />
								</div>
							</div>
						</div>
						
						<div class="form-group form-group-label">
							<div class="row">
								<div class="col-lg-6 col-sm-8">
									<label class="floating-label" for="taller">Taller</label>
									<select class="form-control" name="taller" id="form-select">
										<option value="blender">Blender (10 - 12)</option>
										<option value="nodejs">NodeJS (12 - 14)</option>
										<option value="perimetral">Seguridad Perimetral (14 - 16)</option>
										<option value="hackios">Hackeo iOS y Android (16 - 18)</option>
										<option value="bb10">BlackBerry 10 (10 - 12)</option>
										<option value="librecad">LibreCAD (12 - 14)</option>
										<option value="android-1">Android básico (14 - 16)</option>
										<option value="android-2">Android intermedio (16 - 18)</option>
										<option value="videojuegos">Videojuegos (10 - 12)</option>
										<option value="firefoxos-1">Firefox OS básico (12 - 14)</option>
										<option value="firefoxos-2">Firefox OS intermedio (14 - 16)</option>
										<option value="arduino">Arduino (16 - 18)</option>
									</select>
								</div>
							</div>
						</div>
					</fieldset>

					<div class="form-group-btn">
						<button class="btn btn-blue waves-button waves-light waves-effect" type="submit" name="submit">Enviar</button>
					</div>
					
				</form>
			</div>
		</div>
	</div>
	<!-- FIN Contenido principal -->

	<!-- Pie de página. -->
	<?php include 'pie.php'; ?>

	<script src="/js/material/base.min.js"></script>
	<script src="js/registro.js"></script>
	<!-- end scripts -->
		
</body>
</html>