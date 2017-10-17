$(document).ready(function(){

	$('#codigo').keyup(function(){
		this.value = this.value.replace(/[^0-9]/g,'');
		});
		
	
		$('#nombre').keyup(function(){
			this.value = this.value.replace(/[^a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ]/g,'');
			});
					
			
			$('#btn-validar').click(function(e) {
		e.preventDefault();
		var cod = $.trim($('#codigo').val());
		var nom = $.trim($('#nombre').val());
		var fac = $.trim($('#facultad').val())	

$(".error").remove();$(".error2").remove();$(".error3").remove();
	if(validar(cod,fac,nom)){
			//if(true){
				enviar();
			}
	
			});
			
			function validar(cod,fac,nom){
     
				if( cod == "" ){
	$(".error_div").focus().after(" <div class='error alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Escriba el codigo del programa académico.</center></div>");
			return false;
			}else if(cod.length != 4){
	$(".error_div").focus().after(" <div class='error alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Ingrese un codigo de 4 digitos.</center></div>");
			return false;
		}else if( fac == "" ){
	$(".error2_div").focus().after(" <div class='error2 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Seleccione la facultad.</center></div>");
				return false;
				}else if( nom == "" ){
	$(".error3_div").focus().after(" <div class='error3 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Ingrese el nombre.</center></div>");
				return false;
				}
				
				return true;
				}
				
				function enviar(){
			$("#insertForm").submit();		
				}
					
	});