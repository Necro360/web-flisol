jQuery(document).ready(function($){

	// hide messages 
	$("#error").hide();
	$("#sent-form-msg").hide();
	
	// on submit...
	$("#contactForm #submit").click(function() {
		$("#error").hide();
		
		//required:
		
		//name
		var nombre = $("input#nombre").val();
		if(nombre == ""){
			$("#error").fadeIn().text("El nombre es obligatorio.");
			$("input#nombre").focus();
			return false;
		}
		
		// email
		var correo = $("input#correo").val();
		if(correo == ""){
			$("#error").fadeIn().text("Tu correo es obligatorio.");
			$("input#correo").focus();
			return false;
		}
		
		// web
		var universidad = $("input#universidad").val();
		if(universidad == ""){
			$("#error").fadeIn().text("Tu institución es necesaria.");
			$("input#universidad").focus();
			return false;
		}

		var taller = $("select#taller").val();
		if(taller == ""){
			$("#error").fadeIn().text("Falta elegir tu taller.");
			$("input#taller").focus();
			return false;
		}
		
		
		// send mail php
		var registrarUrl = "registrar.php";
		
		// data string
		var dataString = 'nombre='+ nombre
						+ '&correo=' + correo        
						+ '&universidad=' + universidad
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

