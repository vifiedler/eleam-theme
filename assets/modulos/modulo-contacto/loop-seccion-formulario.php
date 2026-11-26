<?php
/**
 * Página Contacto: reutiliza exactamente la sección visual del Inicio.
 * El componente compartido obtiene sus datos de la página Contacto (SCF)
 * y conserva el formulario original de Contact Form 7.
 *
 * @package eleam-theme
 */

defined('ABSPATH') || exit;
get_template_part(
    'assets/modulos/modulo-inicio/loop-contacto',
    null,
    array('eleam_contexto' => 'pagina-contacto')
);
