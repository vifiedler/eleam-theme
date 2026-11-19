/** Control del carrusel «Santo del día», independiente del Bootstrap JS. */
(function () {
  'use strict';

  document.querySelectorAll('[data-santoral]').forEach(function (contenedor) {
    var diapositivas = Array.prototype.slice.call(
      contenedor.querySelectorAll('[data-santoral-diapositiva]')
    );
    if (diapositivas.length < 2) {
      return;
    }

    var anterior = contenedor.querySelector('[data-santoral-anterior]');
    var siguiente = contenedor.querySelector('[data-santoral-siguiente]');
    var posicion = contenedor.querySelector('[data-santoral-posicion]');
    var indice = 0;
    if (!anterior || !siguiente || !posicion) {
      return;
    }

    function irA(nuevoIndice) {
      indice = (nuevoIndice + diapositivas.length) % diapositivas.length;
      diapositivas.forEach(function (diapositiva, i) {
        diapositiva.hidden = i !== indice;
      });
      posicion.textContent = (indice + 1) + ' de ' + diapositivas.length;
    }

    anterior.addEventListener('click', function () { irA(indice - 1); });
    siguiente.addEventListener('click', function () { irA(indice + 1); });
    irA(0);
  });
}());
