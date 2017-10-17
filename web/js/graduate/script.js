$(document).ready(function(){


	var cantidad = $('#cantidad').val();

	for (i = 1; i <= cantidad; i++) {

	$('#documento'+i).keyup(function(){
		this.value = this.value.replace(/[^0-9]/g,'');
		activar();
		});
	
		$('#nombre'+i).keyup(function(){
			this.value = this.value.replace(/[^a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ]/g,'');
			activar();
			});
			
			$('#apellido'+i).keyup(function(){
				this.value = this.value.replace(/[^a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ]/g,'');
				activar();
				});		
					}
					
					
					function activar(){
						var cantidad = $('#cantidad').val();
	var activar = false;
	for (i = 1; i <= cantidad; i++) {
						var nuip = $.trim($('#documento'+i).val());	
						var nombre = $.trim($('#nombre'+i).val());
						var apellido = $.trim($('#apellido'+i).val());					
			activar = activar || XOR(nuip,nombre,apellido);
						}
	
		if(activar){
			$('#btn_validar').prop('disabled', true);
		}else{
			$('#btn_validar').prop('disabled', false);
		}

		}
					
					function XOR(a,b,c){
						return (a === '') ^ (b === '') || (a === '') ^ (c === '') ;
					}
				
					
	});