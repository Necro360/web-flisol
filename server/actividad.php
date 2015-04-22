<?php
	require_once '_bdconfig.php';
	require_once '_mysql.php';

	$slugtaller = $_GET['slug'];
	if (isset($slugtaller)) {
		// Conectar a la base de datos
		$mysql = new MySQL(BD_HOST, BD_USER, BD_PASS, BD_NAME);

		// Buscar el taller correspondiente
		$slugtaller = $mysql->blindar(stripslashes($slugtaller));
		$taller = $mysql->ejecutar("SELECT id, nombre, descripcion, ponente, horainicio, horafin, ubicacion, cupo, sobrecupo" . 
			" FROM talleres WHERE abrev='" . $slugtaller . "'");

		// Revisar si se encontró un taller con la abreviación necesaria
		if ($taller !== FALSE) {
			$taller = $taller->fetch_assoc();
			$horario = date("G:i - ", strtotime($taller['horainicio'])) . date("G:i", strtotime($taller['horafin']))
				. " horas";
			$ponente = $mysql->ejecutar("SELECT organiza, usuario, biografia FROM ponentes WHERE id=" . $taller['ponente']);

			// Verificar ocupación actual del taller y cupo máximo permitido para estilizar el botón correspondiente
			$ocupacion = $mysql->ejecutar("SELECT COUNT(*) FROM usuariotaller WHERE idtaller=" . $taller['id']);
			$maximo = $taller['cupo'] + $taller['sobrecupo'];
			$puedeinscribir = $ocupacion->fetch_row() < $maximo ? ' disabled': '';

			// Revisar si se encontró un ponente adscrito al taller
			if ($ponente !== FALSE) 
				$ponente = $ponente->fetch_assoc();			
?>

<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	
	<title><?php echo ($taller['nombre']); ?> - FLISoL Aragón 2015</title>
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
			<div class="container">
				<h1 class="heading"><?php echo ($taller['nombre']); ?></h1>
			</div>
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
						
		        		<h4><?php echo ($taller['nombre']); ?></h4>
		        		<!-- Descripción del taller/conferencia -->
		        		<?php echo ($taller['descripcion']); ?>
		        		<!-- FIN Descripción del taller/conferencia -->

		        		<h4>Ubicación y horario</h4>
		        		<p><?php echo ($taller['ubicacion']); ?><br />
		        		Facultad de Estudios Superiores Aragón<br />
		        		<?=$horario?></p>

		        		<!-- PENDIENTE: Reemplazar este botón con algo más adecuado si no es un taller -->
		        		<?php echo "<a$puedeinscribir class=\"btn btn-blue waves-button waves-effect waves-light\""
		        		. " href=\"/registro\">Inscríbete ahora</a>" ?>
					</div>
					<div class="tab-pane fade" id="infoponente">
						<p class="text-center">
							<span class="avatar avatar-inline avatar-lg">
								<?php echo "<img src=\"/img/ponentes/{$ponente['usuario']}.png\" alt=\"{$ponente['organiza']}\" />"; ?>
							</span>
						</p>
						<div class="text-center">
							<h2><?php echo ($ponente['organiza']); ?></h2>
							<!-- Biografía del ponente -->
							<p>
								<?php echo ($ponente['biografia']); ?>
							</p>
		        			<!-- FIN Biografía del ponente -->
						</div>
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

<?php
		}
		// PENDIENTE: Fallar de una manera más agraciada (con un error 500 personalizado, por ejemplo)
		else {
			die('Error al procesar ponente.');
		}
	// PENDIENTE: Íbidem que arriba.
	} else {
		die('Error al procesar taller.');
	}
?>