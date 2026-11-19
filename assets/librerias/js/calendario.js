<<<<<<< HEAD

=======
>>>>>>> 8f2f9f1058e78733050e7b8da730f3809706246e
(function ($) {
  'use strict';

  $(function () {
    if (typeof $.fn.slick !== 'function') {
      console.error('Calendario: Slick no está disponible.');
      return;
    }

    const VELOCIDAD_AUTOPLAY = 15000;
    const VELOCIDAD_MANUAL = 1800;
<<<<<<< HEAD
    const HITOS_POR_FLECHA = 1;
=======
>>>>>>> 8f2f9f1058e78733050e7b8da730f3809706246e

    $('.calendario-liturgico-pista').each(function () {
      const $pista = $(this);
      if ($pista.hasClass('slick-initialized')) return;

      const $calendario = $pista.closest('.calendario-liturgico');
      const $botonPlay = $calendario.find(
        '[data-calendario-accion="reproducir"]'
      );
      const $botonPausa = $calendario.find(
        '[data-calendario-accion="pausar"]'
      );

      let reproduciendo = false;
      let navegacionManual = false;
      let animacionActiva = null;
      let trackAnimado = null;
      let siguienteFrame = null;

      // Mantener un único botón Play/Pausa.
      $botonPausa.remove();

      // Slick administra los hitos, no el autoplay.
      $pista.slick({
        accessibility: true,
        arrows: false,
        autoplay: false,
        cssEase: 'linear',
        infinite: true,
        pauseOnFocus: false,
        pauseOnHover: false,
        slidesToScroll: 1,
        slidesToShow: 4,
        speed: VELOCIDAD_AUTOPLAY,
        swipe: false,
        touchMove: false,
        waitForAnimate: false,
        responsive: [
          { breakpoint: 992, settings: { slidesToShow: 3 } },
          { breakpoint: 768, settings: { slidesToShow: 2 } },
          { breakpoint: 576, settings: { slidesToShow: 1 } }
        ]
      });

      const slick = $pista.slick('getSlick');

      function obtenerTrack() {
        return slick.$slideTrack[0];
      }

      // Desactivar la transición CSS convencional.
      obtenerTrack().style.setProperty(
        'transition',
        'none',
        'important'
      );

      // Actualizar el botón y su accesibilidad.
      function actualizarBoton() {
        const accion = reproduciendo
          ? 'Pausar calendario'
          : 'Reproducir calendario';

        $botonPlay.attr({
          'aria-label': accion,
          'aria-pressed': String(reproduciendo),
          title: accion
        });

        $botonPlay.find('.bi')
          .removeClass('bi-play-fill bi-pause-fill')
          .addClass(
            reproduciendo ? 'bi-pause-fill' : 'bi-play-fill'
          );
      }

      function cancelarSiguienteFrame() {
        if (siguienteFrame !== null) {
          cancelAnimationFrame(siguienteFrame);
          siguienteFrame = null;
        }
      }

      // Conservar la posición visual antes de interrumpir.
      function congelarYCancelar() {
        if (!animacionActiva) return;

        const track = trackAnimado;
        const posicion = window.getComputedStyle(track).transform;
        const animacionAnterior = animacionActiva;

        animacionActiva = null;
        trackAnimado = null;

        animacionAnterior.onfinish = null;
        animacionAnterior.cancel();

        track.style.setProperty(
          'transition',
          'none',
          'important'
        );

        if (posicion !== 'none') {
          track.style.transform = posicion;
        }

        slick.animating = false;
      }

      // Programar el siguiente movimiento continuo.
      function programarSiguienteHito() {
        cancelarSiguienteFrame();

        if (!reproduciendo) return;

        siguienteFrame = requestAnimationFrame(function () {
          siguienteFrame = null;

          if (
            !reproduciendo ||
            animacionActiva ||
            slick.unslicked
          ) return;

          navegacionManual = false;
          $pista.slick('slickNext');
        });
      }

      // Override del motor de animación de Slick.
      slick.animateSlide = function (destino, callback) {
        if (animacionActiva) {
          congelarYCancelar();
        }

        const track = obtenerTrack();
        const desde = window.getComputedStyle(track).transform;

        const posicion = slick.options.rtl &&
          !slick.options.vertical
          ? -destino
          : destino;

        const hasta = slick.options.vertical
          ? `translate3d(0px, ${Math.ceil(posicion)}px, 0px)`
          : `translate3d(${Math.ceil(posicion)}px, 0px, 0px)`;

        const duracion = navegacionManual
          ? VELOCIDAD_MANUAL
          : VELOCIDAD_AUTOPLAY;

        const easing = navegacionManual
          ? 'ease-in'
          : 'linear';

        track.style.setProperty(
          'transition',
          'none',
          'important'
        );

        // Animación nativa controlable.
        const animacion = track.animate(
          [
            {
              transform: desde === 'none'
                ? 'translate3d(0px, 0px, 0px)'
                : desde
            },
            {
              transform: hasta
            }
          ],
          {
            duration: duracion,
            easing: easing,
            fill: 'forwards'
          }
        );

        animacionActiva = animacion;
        trackAnimado = track;

        animacion.onfinish = function () {
          if (animacionActiva !== animacion) return;

          // Conservar el destino antes de retirar la animación.
          track.style.transform = hasta;

          animacionActiva = null;
          trackAnimado = null;
          animacion.cancel();

          // Permitir que Slick actualice índices y clones.
          if (typeof callback === 'function') {
            callback.call(slick);
          }

          navegacionManual = false;
          programarSiguienteHito();
        };
      };

      // Gestionar reconstrucciones responsive de Slick.
      $pista.on('reInit.calendario', function () {
        cancelarSiguienteFrame();

        if (animacionActiva) {
          animacionActiva.onfinish = null;
          animacionActiva.cancel();
          animacionActiva = null;
          trackAnimado = null;
        }

        slick.animating = false;
        programarSiguienteHito();
      });

      // Flechas: desplazar cuatro hitos con ease-in.
      function moverCuatroHitos(direccion) {
        cancelarSiguienteFrame();
        congelarYCancelar();

        navegacionManual = true;

        const indiceActual = $pista.slick(
          'slickCurrentSlide'
        );

        $pista.slick(
          'slickGoTo',
          indiceActual + direccion * HITOS_POR_FLECHA
        );

        if (!animacionActiva) {
          navegacionManual = false;
          programarSiguienteHito();
        }
      }

      $calendario
        .find('[data-calendario-accion="anterior"]')
        .on('click.calendario', function () {
          moverCuatroHitos(-1);
        });

      $calendario
        .find('[data-calendario-accion="siguiente"]')
        .on('click.calendario', function () {
          moverCuatroHitos(1);
        });

      // Botón Play/Pausa con congelación instantánea.
      $botonPlay.on('click.calendario', function () {
        reproduciendo = !reproduciendo;

        if (reproduciendo) {
          if (animacionActiva) {
            // Reanuda exactamente donde se pausó.
            if (animacionActiva.playState === 'paused') {
              animacionActiva.play();
            }
          } else {
            // Inicia el movimiento si todavía no existe.
            programarSiguienteHito();
          }
        } else {
          // Congela la posición actual de la animación.
          cancelarSiguienteFrame();

          if (animacionActiva) {
            animacionActiva.pause();
          }
        }

        actualizarBoton();
      });

      // Estado inicial: completamente pausado.
      actualizarBoton();
    });
  });
<<<<<<< HEAD
}(jQuery));
=======
}(jQuery));
>>>>>>> 8f2f9f1058e78733050e7b8da730f3809706246e
