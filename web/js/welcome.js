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

