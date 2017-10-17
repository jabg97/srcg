$(document).ready(function() {

    $('.codigo').keyup(function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('.capacidad').keyup(function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('.zonas').keyup(function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('.filas').keyup(function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('.columnas').keyup(function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    })

    $('.nombre').keyup(function() {
        this.value = this.value.replace(/[^a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ]/g, '');
    })
    $('.btn-validar').click(function(e) {
        e.preventDefault();
        var cod = $.trim($('.codigo').val());
        var cap = $.trim($('.capacidad').val());
        var zon = $.trim($('.zonas').val());
        var fil = $.trim($('.filas').val());
        var col = $.trim($('.columnas').val());
        var nom = $.trim($('.nombre').val());
        var dir = $.trim($('.direccion').val());

        $(".error").remove();
        $(".error2").remove();
        $(".error3").remove();
        $(".error4").remove();
        $(".error5").remove();
        $(".error6").remove();
        $(".error7").remove();

        if (validar(cod, cap, zon, fil, col, nom, dir)) {
            //if(true){
            enviar();
        }

    });

    function validar(cod, cap, zon, fil, col, nom, dir) {

        if (cod == "") {
            $(".error_div").focus().after(" <div class='error alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Escriba el codigo de la ubicacion.</center></div>");
            return false;
        } else if ((cod.length < 1) || (cod.length > 2)) {
            $(".error_div").focus().after(" <div class='error alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Ingrese un codigo entre 1 y 2 digitos.</center></div>");
            return false;
        } else if (cap == "") {
            $(".error2_div").focus().after(" <div class='error2 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Ingrese la capacidad de la ubicacion.</center></div>");
            return false;
        } else if ((cap.length < 1) || (cap.length > 6)) {
            $(".error2_div").focus().after(" <div class='error2 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Ingrese la capacidad entre 1 y 6 digitos.</center></div>");
            return false;
        } else if (zon == "") {
            $(".error3_div").focus().after(" <div class='error3 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Ingrese las zonas de la ubicacion.</center></div>");
            return false;
        } else if (zon.length != 1) {
            $(".error3_div").focus().after(" <div class='error3 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Ingrese la cantidad de zonas solo un digito.</center></div>");
            return false;
        } else if ((zon < 1) || (zon > 3)) {
            $(".error3_div").focus().after(" <div class='error3 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Ingrese las zona minimo 1 y maximo 3.</center></div>");
            return false;
        } else if (fil == "") {
            $(".error4_div").focus().after(" <div class='error4 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Ingrese las filas de la ubicacion.</center></div>");
            return false;
        } else if ((fil.length < 1) || (fil.length > 3)) {
            $(".error4_div").focus().after(" <div class='error4 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Ingrese las filas entre 1 y 3 digitos.</center></div>");
            return false;
        } else if (col == "") {
            $(".error5_div").focus().after(" <div class='error5 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Ingrese las columnas de la ubicacion.</center></div>");
            return false;
        } else if ((col.length < 1) || (col.length > 3)) {
            $(".error5_div").focus().after(" <div class='error5 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Ingrese las columnas entre 1 y 3 digitos.</center></div>");
            return false;
        } else if (nom == "") {
            $(".error6_div").focus().after(" <div class='error6 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Ingrese el nombre.</center></div>");
            return false;
        } else if (dir == "") {
            $(".error7_div").focus().after(" <div class='error7 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Ingrese la direccion.</center></div>");
            return false;
        }

        return true;
    }

    function enviar() {
        $(".insertForm").submit();
    }

});