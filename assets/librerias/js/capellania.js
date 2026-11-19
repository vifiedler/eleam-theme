(function () {
  'use strict';

  document.querySelectorAll('[data-publicacion]').forEach(function (publicacion) {
    var control = publicacion.querySelector('.publicacion-control');
    var detalle = publicacion.querySelector('.publicacion-detalle');
    var textoControl = control ? control.querySelector('.publicacion-control-texto') : null;
    var iconoControl = control ? control.querySelector('.bi') : null;

    if (!control || !detalle || !textoControl || !iconoControl) {
      return;
    }

    detalle.addEventListener('show.bs.collapse', function () {
      control.setAttribute('aria-expanded', 'true');
      textoControl.textContent = 'Ocultar detalle';
      iconoControl.className = 'bi bi-arrow-up';
    });

    detalle.addEventListener('hide.bs.collapse', function () {
      control.setAttribute('aria-expanded', 'false');
      textoControl.textContent = 'Ver más';
      iconoControl.className = 'bi bi-arrow-down';
    });
  });
<<<<<<< HEAD
}());
=======
}());
>>>>>>> 8f2f9f1058e78733050e7b8da730f3809706246e
