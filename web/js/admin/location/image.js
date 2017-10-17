'use strict';

;
(function($, window, document, undefined) {
    $('.image').each(function() {
        var $input = $(this),
            $label = $input.next('label'),
            labelVal = $label.html();

        $input.on('change', function(e) {

            $(".image").focus().after("");
            $(".error9").remove();

            var fileName = '';

            if (this.files && this.files.length > 1)
                fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
            else if (e.target.value)
                fileName = e.target.value.split('\\').pop();

            if (fileName) {
                $label.find('span').html(fileName);
                var fileExt = fileName.substring(fileName.lastIndexOf('.'));

                if (fileExt != ".jpeg" && fileExt != ".JPEG" && fileExt != ".jpg" && fileExt != ".JPG") {
                    $(".image_div").focus().after(" <div class='error9 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left fa-1x'></i>&nbsp;&nbsp;Error!</strong> Imagen no válida.</center></div>");
                } else {
                    $(".image_div").focus().after(" <div class='error9 alert bg-success text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-check left fa-1x'></i>&nbsp;&nbsp;Correcto!</strong></center></div>");
                }
            }
        });

    });
})(jQuery, window, document);