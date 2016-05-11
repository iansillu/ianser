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

