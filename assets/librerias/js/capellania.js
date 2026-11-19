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
jQuery(function ($) {
	var $pista = $('.calendario-liturgico-pista');

	if (!$pista.length || !$.fn.slick) {
		return;
	}

	var reducirMovimiento = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	$pista.slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		infinite: true,
		arrows: false,
		dots: false,
		autoplay: !reducirMovimiento,
		autoplaySpeed: 0,
		speed: 6000,
		cssEase: 'linear',
		pauseOnHover: true,
		pauseOnFocus: true,
		responsive: [
			{ breakpoint: 992, settings: { slidesToShow: 3 } },
			{ breakpoint: 768, settings: { slidesToShow: 2 } },
			{ breakpoint: 576, settings: { slidesToShow: 1 } }
		]
	});

	$('.calendario-liturgico-controles').on('click', '[data-calendario-accion]', function () {
		switch ($(this).data('calendario-accion')) {
			case 'anterior':
				$pista.slick('slickPrev');
				break;
			case 'siguiente':
				$pista.slick('slickNext');
				break;
			case 'reproducir':
				$pista.slick('slickPlay');
				break;
			case 'pausar':
				$pista.slick('slickPause');
				break;
		}
	});
});