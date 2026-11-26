(function () {
  'use strict';

  document.querySelectorAll('.seccion-talleres').forEach(function (seccion) {
    var radios = seccion.querySelectorAll('.taller-radio');
    var botones = seccion.querySelectorAll('.taller-boton');
    var paneles = seccion.querySelectorAll('.taller-panel');

    function actualizar() {
      var seleccionado = seccion.querySelector('.taller-radio:checked');
      var id = seleccionado ? seleccionado.id : '';

      botones.forEach(function (boton) {
        boton.classList.toggle('is-activo', boton.getAttribute('for') === id);
      });

      paneles.forEach(function (panel) {
        panel.classList.toggle(
          'is-activo',
          id !== '' && panel.classList.contains('panel-' + id.replace('taller-', ''))
        );
      });
    }

    radios.forEach(function (radio) {
      radio.addEventListener('change', actualizar);
    });

    actualizar();
  });
}());
