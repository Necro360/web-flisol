jQuery(document).ready(function($){

	// Elementos de carga y respuesta ocultos inicialmente
	$("#loading, #message").hide();

	// Validar al enviar el formulario
	$("#talleresForm").on('submit', function() {
		// ** Validación de datos **
		var correo = $("[name=correo]").val();
		if (correo == "" || !/^[\w\.]+@[\w\.]+[^\.]$/.test(correo)) {
			$("#message").show().text("Verifica que esté escrito (correctamente) tu correo.");
			$("[name=correo]").focus();
			return false;
		}

		var nombre = $("[name=nombre]").val();
		if (nombre == "") {
			$("#message").show().text("El nombre es obligatorio.");
			$("[name=nombre]").focus();
			return false;
		}

		var apellidos = $("[name=apellidos]").val();
		if (apellidos == "") {
			$("#message").show().text("Escribe tus apellidos, por favor.");
			$("[name=apellidos]").focus();
			return false;
		}

		var institucion = $("[name=institucion]").val();
		if (institucion == "") {
			$("#messsage").show().text("Tu institución es necesaria.");
			$("[name=institucion]").focus();
			return false;
		}

		var taller = $("[name=taller]").val();
		if (taller == "null") {
			$("#message").show().text("Falta elegir tu taller.");
			$("[name=taller]").focus();
			return false;
		}
		// ** FIN Validación de datos **

		// Desactivar el botón de envío y mostrar el progreso de carga
		$("#loading").show();
		$("[name=submit]").attr('disabled', '');

		$.ajax({
			type: "POST",
			url: "/server/intentRegistro.php",
			data: {
				correo: $("[name=correo]").val(),
				nombre: $("[name=nombre]").val(),
				apellidos: $("[name=apellidos]").val(),
				institucion: $("[name=institucion]").val(),
				taller: $("[name=taller]").val()
			}
		})

		.done(function(data) {
			var json = $.parseJSON(data);
			if (json.success)
				$("[name=submit]").attr('disable', '');

			$("#loading").show().text(json.message);
		})

		.always(function() {
			$("#loading").hide();
			$("[name=submit]").removeAttr('disabled');
		})

		.fail(function() {
			$("#message").show().text("Comprueba tu conexión e inténtalo de nuevo.");
		});

		return false;
	});

	$("#talleresForm").on('reset', function() {
		$("[name=correo], [name=nombre], [name=apellidos], [name=institucion]").removeAttr('disabled');
		$("#message").hide();
		$("[name=correo]").focus();
		return true;
	});

	// Autorrellenado del formulario
	$("[name=correo]").on('blur', function() {
		var correo = $("[name=correo]").val();
		if (correo != "" && /^[\w\.]+@[\w\.]+[^.]$/.test(correo)) {
			// Desactivar el botón de envío y mostrar el progreso de carga
			$("#loading").show();
			$("[name=submit]").attr('disabled', '');

			// Solicitud AJAX de datos existentes
			$.ajax({
				type: 'POST',
				url: '/server/intentRegistro.php',
				data: {
					'autocompletefrom': correo
				}
			})

			// En caso de que la solicitud sea existosa
			.done(function(data, textStatus) {
				console.log(data);
				if (data !== null) {
					$("[name=nombre]").val(data.nombre);
					$("[name=apellidos]").val(data.apellidos);
					$("[name=institucion]").val(data.institucion);
					$("[name=correo], [name=nombre], [name=apellidos], [name=institucion]").attr('disabled', '').parent()
						.parent().parent().addClass('control-highlight');
				}
			})

			.error(function() {})

			// Al terminar la solicitud, en cualquier caso
			.always(function() {
				$("#loading").hide();
				$("[name=submit]").removeAttr('disabled');
			});
		}
	});

	$("#contactForm #submit").click(function() {
		$("#error").hide();

		//required:




		// send mail php
		var registrarUrl = "registrar.php";

		// data string
		var dataString = 'nombre='+ nombre
						+ '&correo=' + correo
						+ '&universidad=' + institucion
						+ '&taller=' + taller;

		// ajax
		$.ajax({
			type:"POST",
			url: registrarUrl,
			data: dataString,
			success: success()
		});
	});


	// on success...
	 function success(){
	 	$("#sent-form-msg").fadeIn();
	 	$("#contactForm").fadeOut();
	 }

    return false;
});
