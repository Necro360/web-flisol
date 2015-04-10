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
			$("#error").fadeIn().text("Tu nombre es obligatorio.");
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
		var institucion = $("input#institucion").val();
		if(institucion == ""){
			$("#error").fadeIn().text("Tu institución es necesaria.");
			$("input#institucion").focus();
			return false;
		}
		
		// comments
		var mensaje = $("#mensaje").val();
		
		// send mail php
		var sendMailUrl = "contactar.php";
		
		// data string
		var dataString = 'nombre='+ nombre
						+ '&correo=' + correo        
						+ '&institucion=' + institucion
						+ '&mensaje=' + mensaje;						         
		// ajax
		$.ajax({
			type:"POST",
			url: sendMailUrl,
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

