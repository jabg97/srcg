$(document).ready(function() {

    $('#codigo').keyup(function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('#password').keyup(function() {
        this.value = this.value.replace(/[^A-Za-z0-9]/g, '');
    });

    $('#nombre').keyup(function() {
        this.value = this.value.replace(/[^a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ]/g, '');
    });

    $('#apellido').keyup(function() {
        this.value = this.value.replace(/[^a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ]/g, '');
    });



    $('#btn-validar').click(function(e) {
        e.preventDefault();
        var cod = $.trim($('#codigo').val());
        var pass = $.trim($('#password').val());
        var email = $.trim($('#email').val());
        var nom = $.trim($('#nombre').val());
        var ape = $.trim($('#apellido').val());
        var pro = $.trim($('#programa').val());


        $(".error").remove();
        $(".error2").remove();
        $(".error3").remove();
        $(".error4").remove();
        $(".error5").remove();
        $(".error6").remove();
        $(".errorfacu").remove();
        if (validar(cod, pass, email, nom, ape, pro)) {
            //if(true){
            enviar();
        }

    });

    function validar(cod, pass, email, nom, ape, pro) {

        if (cod == "") {
            $(".error_div").focus().after(" <div class='error alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left fa-1x'></i>&nbsp;&nbsp;Error!</strong> Escriba el codigo del graduando.</center></div>");
            return false;
        } else if (cod.length != 9) {
            $(".error_div").focus().after(" <div class='error alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left fa-1x'></i>&nbsp;&nbsp;Error!</strong> Ingrese un codigo de 9 digitos.</center></div>");
            return false;
        } else if ((pass != "" && pass.length < 6) || pass.length > 20) {
            $(".error2_div").focus().after(" <div class='error2 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left fa-1x'></i>&nbsp;&nbsp;Error!</strong> Ingrese una contrase&ntilde;a entre 6 y 20 digitos.</center></div>");
            return false;
        } else if (!(/^([a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3})$/.test(email))) {
            $(".error3_div").focus().after(" <div class='error3 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left fa-1x'></i>&nbsp;&nbsp;Error!</strong> Escriba un email válido.</center></div>");
            return false;
        } else if (pro == "") {
            $(".error6_div").focus().after(" <div class='error6 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left fa-1x'></i>&nbsp;&nbsp;Error!</strong> Seleccione el programa academico.</center></div>");
            return false;
        } else if (nom == "") {
            $(".error4_div").focus().after(" <div class='error4 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left fa-1x'></i>&nbsp;&nbsp;Error!</strong> Ingrese el nombre.</center></div>");
            return false;
        } else if (ape == "") {
            $(".error5_div").focus().after(" <div class='error5 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left fa-1x'></i>&nbsp;&nbsp;Error!</strong> Ingrese el apellido.</center></div>");
            return false;
        }

        return true;
    }

    function enviar() {
        $("#insertForm").submit();
    }

});