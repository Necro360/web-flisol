<?php
	/*
		Gestionar los intentos de registro a los talleres del FLISoL Aragón 2015
		(C) 2014-2015, Rodrigo Moreno, Guillermo Villafuerte
	*/

	require_once '_bdconfig.php';
	require_once '_htmltag.php';
	require_once '_mysql.php';

	$mysql = new MySQL(BD_HOST, BD_USER, BD_PASS, BD_NAME);

	// Establecer encabezado JSON de respuesta
	header('Content-Type: application/json');

	// Devolver datos de autocompletado si es necesario
	if (isset($_POST['autocompletefrom'])) {
		$returndata = $mysql->ejecutar("SELECT nombre, apellidos, institucion FROM usuarios WHERE correoelec='" .
			$mysql->blindar(stripslashes($_POST['autocompletefrom'])) . "'");

		if ($returndata !== false) {
			echo json_encode($returndata->fetch_assoc());
			exit(0);
		}
		else {
			echo json_encode(array());
			exit(1);
		}
	}

	// Comprobación rápida de datos
	// (la comprobación real la debemos realizar en *registro.php*)
	if (!empty($_POST['correo']) && preg_match("^[\w\.]+@[\w\.]+[^.]$", $_POST['correo']) &&
		!empty($_POST['nombre']) &&
		!empty($_POST['apellidos']) &&
		!empty($_POST['institucion']) &&
		!empty($_POST['taller'])) {

		// Blindaje de datos
		$correo = $mysql->blindar(stripslashes($_POST['correo']));
		$nombre = $mysql->blindar(stripslashes($_POST['nombre']));
		$apellidos = $mysql->blindar(stripslashes($_POST['apellidos']));
		$institucion = $mysql->blindar(stripslashes($_POST['institucion']));
		$taller = $mysql->blindar(stripslashes($_POST['taller']));

		// Obtener la información del taller al que se intenta inscribir
		$infotaller = $mysql->ejecutar("SELECT nombre, fechainicio, fechafin FROM talleres WHERE abrev='" . $taller);
		if ($infotaller !== false)
			$infotaller = $infotaller->fetch_assoc();
		else 
			respuesta(false, 'El taller al cual te intentas inscribir no existe.');

		// Obtener el id del usuario, si no existe, crear el registro y obtener su id
		$idusuario = usuarioExiste($correo);
		if ($idusuario != -1) {

		}
	}

	else
		respuesta(false, 'Rellena el formulario completamente para continuar.');
	

	function usuarioExiste($correo) {
		$usuarioexiste = $mysql->ejecutar("SELECT id FROM usuarios WHERE correoelec='" . $correo . "'");
		if ($usuarioexiste !== false)
			return $usuarioexiste->fetch_row()[0];
		else
			return -1;
	}

	function respuesta($success, $message) {
		$array = array('success' => $success, 'message' => $message);
		echo utf8_encode(json_encode($array));
		exit(1);
	}

?>
