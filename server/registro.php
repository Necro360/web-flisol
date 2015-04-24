<?php
	require_once '_bdconfig.php';
	require_once '_mysql.php';

	$mysql = new MySQL(BD_HOST, BD_USER, BD_PASS, BD_NAME);

	$talleres = $mysql->ejecutar("SELECT t.nombre, t.abrev, t.horainicio, t.horafin, t.cupo, count(u.idtaller) AS ocupacion FROM talleres AS t LEFT JOIN usuariotaller AS u ON (t.id = u.idtaller) GROUP BY t.id");
?>

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

	<link rel="stylesheet" href="/css/material/base.min.css" />
	<link rel="stylesheet" media="all" href="/css/registro.css"/>
</head>
<body class="page-blue">

	<!-- Encabezado y barra de navegación. -->
	<?php include 'encabeza.php'; ?>
	<!-- FIN Encabezado, barra navegación -->


	<!-- Contenido principal -->
	<div class="content">
		<div class="content-heading">
			<div class="container">
				<h1 class="heading">Regístrate a nuestros talleres</h1>
			</div>
		</div>

		<div class="content-inner">
			<div class="container">
				<form class="form" id="talleresForm" action="/server/intentRegistro.php" method="post">
					<fieldset>
						<legend>Registro</legend>

						<p>Si ya registraste un taller, solo deberás introducir tu correo y el taller que deseas inscribir.<br />
						Todos los campos son obligatorios. ¡Te esperamos el 28 de abril, no faltes!</p>

						<div class="form-group form-group-label control-highlight">
							<div class="row">
								<div class="col-lg-6 col-sm-8">
									<label class="floating-label" for="correo">Email</label>
									<input name="correo" id="correo" type="email" class="form-control" />
								</div>
							</div>
						</div>

						<div class="form-group form-group-label control-highlight">
							<div class="row">
								<div class="col-lg-6 col-sm-8">
									<label class="floating-label" for="nombre">Nombre</label>
									<input class="form-control" id="nombre" name="nombre" type="text" />
								</div>
							</div>
						</div>

						<div class="form-group form-group-label control-highlight">
							<div class="row">
								<div class="col-lg-6 col-sm-8">
									<label class="floating-label" for="apellidos">Apellidos</label>
									<input class="form-control" id="apellidos" name="apellidos" type="text" />
								</div>
							</div>
						</div>

						<div class="form-group form-group-label control-highlight">
							<div class="row">
								<div class="col-lg-6 col-sm-8">
									<label class="floating-label" for="institucion">Institución</label>
									<input class="form-control" name="institucion"  id="institucion" type="text" />
								</div>
							</div>
						</div>

						<div class="form-group form-group-label">
							<div class="row">
								<div class="col-lg-6 col-sm-8">
									<label class="floating-label" for="taller">Taller</label>
									<select class="form-control" name="taller" id="taller">
										<option value="null">Selecciona un taller...</option>
										<?php
											while ($fila = $talleres->fetch_array()) {
												if ($fila['ocupacion'] < $fila['cupo']) {
													echo "<option value='". $fila['abrev'] ."'>". $fila['nombre'] ." (". date("G:i - ", strtotime($fila['horainicio'])) . date("G:i", strtotime($fila['horafin'])) .")</option>";
												}
											}
										?>
									</select>
								</div>
							</div>
						</div>
					</fieldset>

					<div class="form-group-btn">
						<button class="btn btn-blue waves-button waves-light waves-effect" type="submit" name="submit">Enviar</button>
						<button class="btn btn-red waves-button waves-light waves-effect" type="reset" name="reset">Limpiar</button>
						<div id="loading">
							<img src="/img/loading.gif" alt="Cargando" />
						</div>
					</div>

					<div id="message">¡Muchas gracias por registrarte! Recibirás un correo de confirmación.</div>

				</form>
			</div>
		</div>
	</div>
	<!-- FIN Contenido principal -->

	<!-- Pie de página. -->
	<?php include 'pie.php'; ?>

	<script src="/js/material/base.min.js"></script>
	<script src="/js/registro.js"></script>
	<!-- end scripts -->

</body>
</html>
