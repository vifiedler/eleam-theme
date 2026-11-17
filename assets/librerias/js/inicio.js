(function ($) {
  'use strict';

  $(function () {
    var $carrusel = $('#carrusel-inicio');
    if ($carrusel.length === 0) return;

    var $pista = $carrusel.find('.hero-inicio-pista');
    var $contador = $carrusel.find('.hero-inicio-contador');
    var $puntos = $carrusel.find('.hero-inicio-puntos span');
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
      adaptiveHeight: true,
      arrows: false,
      autoplay: !reduccionDeMovimiento,
      autoplaySpeed: 6000,
      centerMode: true,
      centerPadding: '19%',
      slidesToShow: 1,
      slidesToScroll: 1,
      fade: false,
      speed: 900,
      cssEase: 'ease-in-out',
      infinite: true,
      pauseOnHover: false,
      pauseOnFocus: true,
      responsive: [
        {
          breakpoint: 576,
          settings: {
            centerMode: false,
            centerPadding: '0',
            slidesToShow: 1
          }
        }
      ]
    });

    $carrusel.find('.hero-inicio-flecha-anterior').on('click', function () {
      $pista.slick('slickPrev');
    });

    $carrusel.find('.hero-inicio-flecha-siguiente').on('click', function () {
      $pista.slick('slickNext');
    });
  });
}(jQuery));