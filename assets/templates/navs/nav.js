/**
 * ELEAM · Desplegable del Walker de navegación.
 * Escritorio (mouse): abre por hover, sin convertir «Nosotros» en enlace.
 * Teclado: abre al recibir foco, cierra al salir o pulsar Escape.
 * Móvil/táctil: conserva el comportamiento nativo de <details>/<summary>.
 */
(() => {
    'use strict';

    const iniciar = () => {
        // Compatibilidad con marcado generado por una copia anterior del Walker.
        // Convierte únicamente padres sin dirección en controles <details>/<summary>.
        document.querySelectorAll(
            '.navegacion-principal .navegacion-enlaces > .menu-item-has-children'
        ).forEach((item) => {
            if (item.querySelector(':scope > .navegacion-desplegable')) return;

            const enlace = item.querySelector(':scope > a');
            const submenu = item.querySelector(':scope > .navegacion-submenu');
            if (!enlace || !submenu) return;

            const sinDireccion = !enlace.hasAttribute('href') ||
                enlace.getAttribute('href') === '' ||
                enlace.getAttribute('href') === '#';
            if (!sinDireccion && enlace.textContent.trim() !== 'Nosotros') return;

            item.classList.add('navegacion-secundaria');

            const detalles = document.createElement('details');
            detalles.className = 'navegacion-desplegable';

            const resumen = document.createElement('summary');
            resumen.id = enlace.id || 'eleam-dropdown-nosotros';
            resumen.className = 'nav-link navegacion-disparador';
            resumen.innerHTML = enlace.innerHTML;

            const chevron = document.createElement('span');
            chevron.className = 'bi bi-chevron-down';
            chevron.setAttribute('aria-hidden', 'true');
            resumen.appendChild(chevron);

            detalles.appendChild(resumen);
            detalles.appendChild(submenu);
            enlace.replaceWith(detalles);
        });

        const consultas = document.querySelectorAll(
            '.navegacion-principal .navegacion-desplegable'
        );
        if (!consultas.length) return;

        const escritorio = window.matchMedia(
            '(min-width: 1200px) and (hover: hover) and (pointer: fine)'
        );

        consultas.forEach((desplegable) => {
            const disparador = desplegable.querySelector(':scope > .navegacion-disparador');
            if (!disparador) return;

            const abrir = () => { desplegable.open = true; };
            const cerrar = () => { desplegable.open = false; };

            desplegable.addEventListener('pointerenter', (evento) => {
                if (escritorio.matches && evento.pointerType === 'mouse') abrir();
            });

            desplegable.addEventListener('pointerleave', (evento) => {
                if (escritorio.matches && evento.pointerType === 'mouse'
                    && !desplegable.contains(document.activeElement)) cerrar();
            });

            desplegable.addEventListener('focusin', () => {
                if (escritorio.matches) abrir();
            });
            desplegable.addEventListener('focusout', (evento) => {
                if (!desplegable.contains(evento.relatedTarget)
                    && !(escritorio.matches && desplegable.matches(':hover'))) cerrar();
            });

            desplegable.addEventListener('keydown', (evento) => {
                if (evento.key === 'Escape' && desplegable.open) {
                    cerrar();
                    disparador.focus();
                    evento.preventDefault();
                    evento.stopPropagation();
                }
            });

            // El botón solo existe para abrir el submenú. No hay navegación en el padre.
            document.addEventListener('pointerdown', (evento) => {
                if (!desplegable.contains(evento.target)) cerrar();
            });

            if (typeof escritorio.addEventListener === 'function') {
                escritorio.addEventListener('change', () => {
                    if (!desplegable.contains(document.activeElement)) cerrar();
                });
            }
        });
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', iniciar, { once: true });
    } else {
        iniciar();
    }
})();
