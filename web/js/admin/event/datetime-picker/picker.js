(function() {
				[].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {	
					new SelectFx(el, {
						stickyPlaceholder: false,				
					});
				} );
			})();

moment.locale('es');
var fecha_limite = document.querySelector('#fecha_limite');
var fecha_evento = document.querySelector('#fecha_evento');
var picker_limite = new MaterialDatetimePicker({});
var picker_evento = new MaterialDatetimePicker({})

      picker_limite.on('submit', function(d) {
        fecha_limite.value = d.format("YYYY-MM-DD H:mm");
        //fecha_limite.focus();
      });
    
    fecha_limite.addEventListener('focus', function() {
      picker_limite.open();
    }, false);

    picker_evento.on('submit', function(d) {
        fecha_evento.value = d.format("YYYY-MM-DD H:mm");
       // fecha_limite.focus();
      });


    fecha_evento.addEventListener('focus', function() {
      picker_evento.open();
    }, false);
    