<?php require_once dirname(__FILE__) . "/incluir/configuracion/bd.config.php";
	//Dependencias
	include_once dirname(__FILE__) . "/incluir/clases/claseMySQL.php";

	define("AULA1", 25);	define("AULA2", 18);	define("AULA3", 16);


	$talleres = array("blender", "nodejs", "perimetral", "hackios",
		"bb10", "librecad", "android-1", "android-2",
		"videojuegos", "firefoxos-1", "firefoxos-2", "arduino");

	$aula1 = array("videojuegos", "librecad", "android-1", "android-2");
	$aula2 = array("blender", "firefoxos-1", "firefoxos-2", "hackios");
	$aula3 = array("bb10", "nodejs", "perimetral", "arduino");

	//Inicio comprobaciones	
	if (!empty($_POST["nombre"]))
		$nombre = strtolower($_POST["nombre"]);
	else
		$error = "Falta el nombre";

	if (!empty($_POST["correo"]))
		$correo = strtolower($_POST["correo"]);
	else
		$error = "Falta el correo";

	if (!empty($_POST["universidad"]))
		$universidad = strtolower($_POST["universidad"]);
	else
		$error = "Falta tu Universidad";

	if (!empty($_POST["carrera"]))
		$carrera = $_POST["carrera"];

	if (!empty($_POST["taller"]))
	{
		if (in_array(strtolower($_POST["taller"]), $talleres))
			$taller = strtolower($_POST["taller"]);
		else
			$error = "Algo malo ocurrió";
	}
	else
		$error = "Falto tu taller";

	if (in_array($taller, $aula1))
		$capacidad = AULA1;

	if (in_array($taller, $aula2))
		$capacidad = AULA2;

	if (in_array($taller, $aula3))
		$capacidad = AULA3;

	switch ($taller)
	{
		case "bb10":
			$titulo = "BlackBerry 10";
			$hora = "10 hrs";
		break;

		case "nodejs":
			$titulo = "NodeJS";
			$hora = "12 hrs";
		break;

		case "perimetral":
			$titulo = "Seguridad Perimetral";
			$hora = "14 hrs";
		break;

		case "arduino":
			$titulo = "arduino";
		break;

		case "blender":
			$titulo = "Modelado y animación 3D con Blender";
			$hora = "10 hrs";
		break;

		case "firefoxos-1":
			$titulo = "Firefox OS básico";
			$hora = "12 hrs";
		break;

		case "firefoxos-2":
			$titulo = "Firefox OS intermedio";
			$hora = "14 hrs";
		break;

		case "hackios":
			$titulo = "Hackeo básico iOS y Android";
			$hora = "16 hrs";
		break;

		case "videojuegos":
			$titulo = "Videojuegos multiplataforma";
			$hora = "10 hrs";
		break;

		case "librecad":
			$titulo = "LibreCAD";
			$hora = "12 hrs";
		break;

		case "android-1":
			$titulo = "Android básico";
			$hora = "14 hrs";
		break;

		case "android-2":
			$titulo = "Android intermedio";
			$hora = "16 hrs";
		break;
	}

	if (isset($error))
		exit($error);
	//Fin de las comprobaciones


	$bd = new MySQL(BD_HOST, BD_USER, BD_PASS, BD_NAME);
	$bd->conectar();

	$consultaBuscar = sprintf("SELECT id FROM asistentes WHERE taller = '%s'", $bd->blindar($taller));

	$registros = mysqli_num_rows($bd->ejecutar($consultaBuscar));

	if ($registros < $capacidad)
	{

		$consultaAbusivos = sprintf("SELECT id FROM asistentes WHERE taller = '%s' AND correo = '%s'", $bd->blindar($taller),
			$bd->blindar($correo));

		$abusivo = mysqli_num_rows($bd->ejecutar($consultaAbusivos));

		if ($abusivo == 0)
		{

			if (isset($carrera))
			{
				$insertar = sprintf("INSERT INTO asistentes(nombre, correo, universidad, carrera, taller) 
					VALUES ('%s', '%s', '%s', '%s', '%s')", $bd->blindar($nombre), $bd->blindar($correo),
						$bd->blindar($universidad), $bd->blindar($carrera), $bd->blindar($taller));
			}
			else
			{
				$insertar = sprintf("INSERT INTO asistentes(nombre, correo, universidad, taller) 
					VALUES ('%s', '%s', '%s', '%s')", $bd->blindar($nombre), $bd->blindar($correo),
						$bd->blindar($universidad), $bd->blindar($taller));
			}

			$asunto = "Confirmación de registro";

			$mensaje  = "<p>¡Hola " . $nombre . "!,</p>";
			$mensaje .= "<p>Taller confirmado: " . $titulo . " " . $hora . "</p>";
			$mensaje .= "<p>¡Nos vemos el Jueves 24 de Abril!<br>No faltes</p>";

			$encabezados  = "MIME-Version: 1.0\r\n";
			$encabezados .= "Content-type: text/html; charset=utf-8\r\n";
			$encabezados .= "From: <contacto@flisolaragon.com.mx>";


			if ($bd->ejecutar($insertar))
				mail($correo, $asunto, $mensaje, $encabezados);			
		}
	}
	else
	{
		$insertar = sprintf("INSERT INTO interesados (nombre, correo, universidad, taller)
			VALUES ('%s', '%s', '%s', '%s')", $bd->blindar($nombre), $bd->blindar($correo), $bd->blindar($universidad), $bd->blindar($taller));

		$asunto = "Lista de espera";

		$mensaje  = "<p>¡Hola " . $nombre . "!,</p>";
		$mensaje .= "<p>Lamentablemente el taller: " . $titulo . " ha tenido mucha demanda ";
		$mensaje .= "y no hemos podido asegurar tu lugar, quedarás en la lista de espera.</p>";
		$mensaje .= "<p>De todas formas estás invitado a las grandiosas platicas que tendremos durante todo el día ";
		$mensaje .= "y a los demás talleres que podrás checar en la web de <a href='http://flisolaragon.com.mx'>FLISoL Aragón</a></p>";
		$mensaje .= "<p>¡Nos vemos el Jueves 24 de Abril!<br>No faltes</p>";

		$encabezados  = "MIME-Version: 1.0\r\n";
		$encabezados .= "Content-type: text/html; charset=utf-8\r\n";
		$encabezados .= "From: FLISoL Aragón <contacto@flisolaragon.com.mx>";


		if ($bd->ejecutar($insertar))
			mail($correo, $asunto, $mensaje, $encabezados);
	}

	$bd->desconectar();