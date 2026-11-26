(function ($) {
  'use strict';

  $(function () {
    $('.carrusel-galeria').each(function () {
      var $galeria = $(this);
      var $pista = $galeria.find('.galeria-carrusel');
      var $contador = $galeria.find('.carrusel-contador');
      var $puntos = $galeria.find('.carrusel-puntos span');
      var reduccionDeMovimiento = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

      $pista.on('init reInit afterChange', function (event, slick, currentSlide) {
        var posicion = (currentSlide || 0) + 1;
        $contador.text(posicion + ' de ' + slick.slideCount);
        $puntos.removeClass('esta-activo').eq(currentSlide || 0).addClass('esta-activo');
        $pista.find('.slick-slide').attr('aria-hidden', 'true');
        $pista.find('.slick-active').removeAttr('aria-hidden');
      });

      $pista.slick({
        accessibility: true,
        adaptiveHeight: false,
        arrows: false,
        autoplay: !reduccionDeMovimiento,
        autoplaySpeed: 6000,
        pauseOnFocus: true,
        pauseOnHover: true,
        speed: 500,
        swipeToSlide: true
      });

      $galeria.find('.carrusel-flecha-anterior').on('click', function () {
        $pista.slick('slickPrev');
      });

      $galeria.find('.carrusel-flecha-siguiente').on('click', function () {
        $pista.slick('slickNext');
      });
    });
  });
}(jQuery));