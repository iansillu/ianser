 function OpcioIniciSesio(){
 	$('#BenvingudaBox').fadeOut(function () {
 		 $('#IniciaSesioAcc').fadeIn();
 	});
 	$('#tencaIniciSesio').click(function () {
 		 $('#IniciaSesioAcc').fadeOut(function () {
 		 	 $('#BenvingudaBox').fadeIn();
 		 });
 	})
 }

 function OpcioRegistra(){
 	$('#BenvingudaBox').fadeOut(function () {
 		 $('#RegistraUsuari2').fadeIn();
 	});
 	$('#tencaRegistre').click(function () {
 		 $('#RegistraUsuari2').fadeOut(function () {
 		 	 $('#BenvingudaBox').fadeIn();
 		 });
 	})
 }

 function ComprovaPass(){
 	var pass1 = $('#ianser_userbundle_userregister_password_first').value();
 	alert(pass1);
 	var pass2 = $('#ianser_userbundle_userregister_password_second').value();

 	if(pass2 == pass1){
 		$('#ianser_userbundle_userregister_submit').prop( "disabled" , false );
 	}
 }

