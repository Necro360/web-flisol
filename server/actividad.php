<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	
	<title>Android básico - FLISoL Aragón 2015</title>
	<meta name="description" content="">
	
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="stylesheet" href="/css/material/base.min.css" />
	
</head>
<body class="page-blue">

	<!-- Encabezado y barra de navegación. -->
	<?php include 'encabeza.php'; ?>
	<!-- FIN Encabezado, barra navegación -->
	
	
	<!-- Contenido principal -->
	<div role="main" class="content">
		<div class="content-heading">
			<div class="container"><h1 class="heading">Android básico</h1></div>
		</div>

		<div class="content-inner">
			<!-- page-content -->
			<div class="container">
				<nav class="tab-nav tab-nav-blue">
					<ul class="nav nav-justified">
						<li class="active"><a class="waves-effect" data-toggle="tab" href="#infotaller">Información</a></li>
						<li><a class="waves-effect" data-toggle="tab" href="#infoponente">Acerca del ponente</a></li>
					</ul>
				</nav>

				<div class="tab-content">
					<div class="tab-pane fade active in" id="infotaller">
						
		        		<h4>Android básico</h4>
		        		<p>En este taller se darán a conocer los conceptos básicos necesarios para crear una aplicación móvil para el sistema operativo Android. Se espera que al finalizar el taller el asistente pueda crear su propia aplicación (sencilla).</p>

		        		<h4>Ubicación y horario</h4>
		        		<p>Centro de Apoyo Extracurricular (A-504)<br />
		        		Facultad de Estudios Superiores Aragón<br />
		        		14:00 - 16:00 hrs</p>

		        		<!-- Lo siguiente solo debe aparecer si es un taller.
		        		Si es taller, pero no hay cupo ni sobrecupo, debe aparecer deshabilitado. -->
		        		<button class="btn btn-blue waves-button waves-effect waves-light" href="/registro/android-basico">Inscríbete ahora</button>
					</div>
					<div class="tab-pane fade" id="infoponente">
						<img src="/img/ponentes/sebasgorro.png" />
						<h2>Sebastián Téllez</h2>
	        			<p>Apasionado por la tecnología. Imparte cursos de Android en Appcademy. Cuenta con amplios conocimientos de diversos lenguajes de programación así como de diversas tecnologías. Miembro de la Comunidad de Desarrollo Aragón (codear).</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- FIN Contenido principal -->

	<!-- Pie de página. -->
	<?php include 'pie.php' ?>

	<script src="/js/material/base.min.js"></script>

</body>
</html>