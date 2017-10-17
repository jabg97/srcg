$(document).ready(function() {
    $('input[type=radio][name=tipo_invitados]').change(function() {

        if (this.value == 1) {
            $('#invitados').prop('readonly', true);
            var graduandos = $.trim($('#graduandos').val());
            var espacio = $.trim($('#espacio').val());
            var capacidad = espacio.split("-:-")[1];
            cambiar(graduandos, capacidad);
        } else if (this.value == 0) {
            $('#invitados').prop('readonly', false);
        }
    });



    $('select').on('change', function() {
        alert(this.value);
    })

    $('#invitados').keyup(function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('#pass').keyup(function() {
        this.value = this.value.replace(/[^A-Za-z0-9]/g, '');
    });

    $('#btn_modi').click(function(e) {
        e.preventDefault();
        var pass = $.trim($('#pass').val());
        var inv = $.trim($('#invitados').val());
        var esp = $.trim($('#espacio').val());

        $(".error").remove();
        $(".error2").remove();
        $(".error3").remove();
        if (validar(pass, inv, esp)) {
            //if(true){
            enviar();
        }

    });

    function cambiar(graduandos, capacidad) {
        var resultado = 0;
        if (graduandos > 0 && capacidad > 0) {
            resultado = Math.floor(capacidad / graduandos);
        }
        $('#invitados').val(resultado);

    }


    function validar(pass, inv, esp) {

        if (pass == "") {
            $(".error_div").focus().after(" <div class='error alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Escriba la contraseña.</center></div>");
            return false;
        } else if (pass.length < 1 || pass.length > 20) {
            $(".error_div").focus().after(" <div class='error alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Ingrese una contraseña entre 1 y 20 digitos.</center></div>");
            return false;
        } else if (inv == "") {
            $(".error2_div").focus().after(" <div class='error2 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Escriba la cantidad de invitados.</center></div>");
            return false;
        } else if (inv.length < 1 || inv.length > 4) {
            $(".error2_div").focus().after(" <div class='error2 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> La cantidad de invitados debe tener entre 1 y 4 digitos.</center></div>");
            return false;
        } else if (esp == "") {
            $(".error3_div").focus().after(" <div class='error3 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Seleccione la ubicación de la ceremonia.</center></div>");
            return false;
        }

        return true;
    }

    function enviar() {
        $("#formu").submit();
    }

});