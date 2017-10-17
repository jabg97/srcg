'use strict';

;
(function($, window, document, undefined) {
    $('.inputfile').each(function() {
        var $input = $(this),
            $label = $input.next('label'),
            labelVal = $label.html();

        $input.on('change', function(e) {

            $("#csv_div").focus().after("");
            $(".error").remove();

            var fileName = '';

            if (this.files && this.files.length > 1)
                fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
            else if (e.target.value)
                fileName = e.target.value.split('\\').pop();

            if (fileName) {
                $label.find('span').html(fileName);
                var fileExt = fileName.substring(fileName.lastIndexOf('.'));

                if (fileExt != ".csv" && fileExt != ".CSV") {
                    $("#csv_div").focus().after(" <div class='error alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Archivo no válido.</center></div>");
                } else {
                    $("#mensaje_tutorial").modal('show');
                }
            } else {
                $label.html(labelVal);
            }

        });

        // Firefox bug fix
        $input
            .on('focus', function() { $input.addClass('has-focus'); })
            .on('blur', function() { $input.removeClass('has-focus'); });
    });
})(jQuery, window, document);


$('#btnclear').click(function() {
    $("#mensaje_tutorial").modal('hide');
    $('#etiqueta').html("Registrar Graduandos");
    $('#formCSV')[0].reset()
});

$('#btnsend').click(function() {
    $('#formCSV').submit();
});

$('#btnremoveAll').click(function() {
    $('#formRemoveAll').submit();
});