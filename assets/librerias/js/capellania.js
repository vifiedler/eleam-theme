(function () {
  'use strict';

  document.querySelectorAll('[data-publicacion]').forEach(function (publicacion) {
    var control = publicacion.querySelector('.publicacion-control');
    var detalle = publicacion.querySelector('.publicacion-detalle');
    var textoControl = control ? control.querySelector('.publicacion-control-texto') : null;
    var iconoControl = control ? control.querySelector('.bi') : null;

    if (!control || !detalle || !textoControl || !iconoControl) return;

    var textoExpandir = publicacion.dataset.textoExpandir || 'Ver más';
    var textoColapsar = publicacion.dataset.textoColapsar || 'Ocultar detalle';
    detalle.addEventListener('show.bs.collapse', function () {
      control.setAttribute('aria-expanded', 'true');
      textoControl.textContent = textoColapsar;
      iconoControl.className = 'bi bi-arrow-up';
    });
    detalle.addEventListener('hide.bs.collapse', function () {
      control.setAttribute('aria-expanded', 'false');
      textoControl.textContent = textoExpandir;
      iconoControl.className = 'bi bi-arrow-down';
    });
  });
}());
