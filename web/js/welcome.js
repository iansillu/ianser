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

function ErrorLogin () {
	 $('#ErrorLogin').fadeIn(function() {
	 	$('#ErrorLogin').fadeOut(100000);
	 });
	 console.log('puta');

}