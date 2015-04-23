<?php
	/*
		Gestionar los intentos de registro a los talleres del FLISoL Aragón 2015
		(C) 2014-2015, Rodrigo Moreno, Guillermo Villafuerte
	*/

	require_once '_bdconfig.php';
	require_once '_htmltag.php';
	require_once '_mysql.php';
	require_once '_class.smtp.php';
	require_once '_class.phpmailer.php';

	$mysql = new MySQL(BD_HOST, BD_USER, BD_PASS, BD_NAME);

	// Establecer encabezado JSON de respuesta
	header('Content-Type: application/json');

	// Devolver datos de autocompletado si es necesario
	if (isset($_POST['autocompletefrom'])) {
		$returndata = $mysql->ejecutar("SELECT nombre, apellidos, institucion FROM usuarios WHERE correoelec = '" .
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
	if (!empty($_POST['correo']) &&
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
		$infotaller = $mysql->ejecutar("SELECT id, nombre, horainicio, horafin, cupo FROM talleres WHERE abrev='" . $taller . "'");
		if (!$infotaller = $infotaller->fetch_assoc())
			respuesta(false, 'El taller al cual te intentas inscribir no existe.');

		// Obtener el id del usuario, si no existe, crear el registro y obtener su id
		$idusuario = usuarioExiste($correo);	
		if ($idusuario === -1) {
			if ($mysql->ejecutar("INSERT INTO usuarios VALUES (null, '$nombre', '$apellidos', '$correo', '$institucion')")) {
				$idusuario = $mysql->ejecutar("SELECT id FROM usuarios WHERE correoelec='$correo'")->fetch_row();
			}
			else {
				respuesta(false, 'Error interno de la base de datos.');
			}
		}
		$idusuario = $idusuario[0];

		// Chequeo de abusivos
		$abusivo = $mysql->ejecutar("SELECT COUNT(*) FROM usuariotaller WHERE idtaller='" . $infotaller['id'] . "' AND " .
			"idusuario='" . $idusuario . "'")->fetch_row();
		$abusivo = $abusivo[0] >= 1;

		if ($abusivo)
			respuesta(false, 'Ya te has inscrito a este taller, tramposo.');

		// Crear el registro relacionando el usuario y el taller entre sí
		$ocupacion = $mysql->ejecutar("SELECT COUNT(*) FROM usuariotaller WHERE idtaller='" . $infotaller['id'] . "'")->fetch_row();
		$ocupacion = $ocupacion[0];
		$ensobrecupo = ($ocupacion < $infotaller['cupo']) ? 0 : 1;

		$resultado = $mysql->ejecutar("INSERT INTO usuariotaller VALUES ('$idusuario', '{$infotaller['id']}', CURRENT_TIMESTAMP(), '$ensobrecupo')");

		$mysql->desconectar();
		
		// Enviar el correo necesario de acuerdo al valor de $ensobrecupo
		$mail = new PHPMailer;

		if ($ensobrecupo === 0) {
			$asunto = "Confirmación de registro";

			$mensaje  = "<p>¡Hola, <b>". $nombre ."</b>!,</p>";
			$mensaje .= "<p>Este mensaje confirma que has quedado registrado correctamente al siguiente taller:</p>";
			$mensaje .= "<p><b>Título:</b>". $infotaller['nombre'] ."<br /><b>Horario:</b>". $infotaller['horainicio'] ."-". $infotaller['horafin'] ."</p>";
			$mensaje .= "<p>¡Nos vemos el martes 28 de Abril!<br />No faltes</p>";
		}
		else {
			$asunto = "Lista de espera";

			$mensaje  = "<p>¡Hola, <b>". $nombre ."</b>!,</p>";
			$mensaje .= "<p>Lamentablemente el taller: " . $infotaller['nombre'] . " ha tenido mucha demanda ";
			$mensaje .= "y no hemos podido asegurar tu lugar, quedarás en la lista de espera.</p>";
			$mensaje .= "<p>De todas formas estás invitado a las grandiosas platicas que tendremos durante todo el día ";
			$mensaje .= "y a los demás talleres que podrás checar en la web de <a href='http://flisolaragon.com.mx'>FLISoL Aragón</a></p>";
			$mensaje .= "<p>¡Nos vemos el martes 28 de Abril!<br />No faltes</p>";
		}

		$mail->setFrom('contacto@flisolaragon.com.mx', 'FLISoL Aragón');
		$mail->addAddress($correo, $nombre);
		$mail->Subject = $asunto;
		$mail->Body = $mensaje;

		$mail->WordWrap = 50;
		$mail->IsHTML(true);
		$mail->CharSet = 'UTF-8';

		$mail->isSMTP();
		$mail->Host = 'smtp.sendgrid.net';
		$mail->Port = 25;
		$mail->SMTPAuth = true;
		$mail->Username = 'flisol2015';
		$mail->Password = '';

		if ($resultado) {
			if ($mail->send())
				respuesta(true, 'Registro exitoso');
			else
				$mail->ErrorInfo;
		}
	}

	else {
		//echo preg_last_error();
		respuesta(false, 'Rellena el formulario completamente para continuar.');
	}
	

	function usuarioExiste($correo) {
		$mysql = new MySQL(BD_HOST, BD_USER, BD_PASS, BD_NAME);
		
		$usuarioexiste = $mysql->ejecutar("SELECT id FROM usuarios WHERE correoelec='" . $correo . "'");
		if (!$usuarioexiste = $usuarioexiste->fetch_row())
			return -1;
		
		return $usuarioexiste;
	}

	function respuesta($success, $message) {
		$array = array('success' => $success, 'message' => $message);
		echo utf8_encode(json_encode($array));
		exit(1);
	}

?>
