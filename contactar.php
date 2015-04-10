<?php

	define("ASUNTO", "Contacto desde la web de FLISoL");
	define("PARA", "contacto@flisolaragon.com.mx");

	if (!empty($_POST["correo"]))
		$correo = strip_tags($_POST["correo"]);
	else
		exit("No llego el correo");

	if (!empty($_POST["nombre"]))
		$nombre = strip_tags($_POST["nombre"]);
	else
		exit("No llego el nombre");

	if (!empty($_POST["institucion"]))
		$institucion = strip_tags($_POST["institucion"]);
	else
		exit("No llego la institución");

	if (!empty($_POST["mensaje"]))
		$mensaje = strip_tags($_POST["mensaje"]);
	else
		exit("No llego el mensaje");

	$encabezados  = "MIME-Version: 1.0\r\n";
	$encabezados .= "Content-type: text/html; charset=utf-8\r\n";
	$encabezados .= "From: " . $nombre . " <" . $correo . ">\r\n";
	$encabezados .= "Reply-To: " . $nombre . " <" . $correo . ">\r\n";
	$encabezados .= "X-Mailer: PHP/" . phpversion();

	$texto  = "<p>" . $nombre . " de la institución: " . $institucion . " escrbió lo siguiente:</p>";
	$texto .= "<p>" . $mensaje . "</p>";

	mail(PARA, ASUNTO, $texto, $encabezados);

?>
