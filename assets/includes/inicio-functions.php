<?php
/**
 * Utilidades exclusivas de los componentes de Inicio.
 * Los valores editoriales provienen de SCF y no del marcado de page-index.php.
 *
 * @package eleam-theme
 */

defined('ABSPATH') || exit;

/** Obtiene un campo SCF sin provocar errores si SCF está desactivado. */
function eleam_inicio_campo($nombre, $post_id = false, $defecto = '') {
    if (!function_exists('get_field')) {
        return $defecto;
    }
    $valor = $post_id ? get_field($nombre, $post_id) : get_field($nombre);
    return ($valor === null || $valor === false || $valor === '') ? $defecto : $valor;
}

/** Lee el valor textual de un campo, aplicando su valor por defecto si falta. */
function eleam_inicio_texto($nombre, $post_id = false, $defecto = '') {
    $valor = eleam_inicio_campo($nombre, $post_id, $defecto);
    return is_scalar($valor) ? trim((string) $valor) : $defecto;
}

/** Normaliza los enlaces SCF (Link) y sus destinos de respaldo. */
function eleam_inicio_enlace($nombre, $ruta = '', $rotulo = '') {
    $valor = eleam_inicio_campo($nombre);
    $url = '';
    $titulo = $rotulo;
    $target = '_self';

    if (is_array($valor) && !empty($valor['url'])) {
        $url = (string) $valor['url'];
        $titulo = !empty($valor['title']) ? (string) $valor['title'] : $rotulo;
        $target = (isset($valor['target']) && $valor['target'] === '_blank') ? '_blank' : '_self';
    } elseif (is_string($valor) && trim($valor) !== '') {
        $url = $valor;
    }

    if ($url === '' && $ruta !== '') {
        $url = home_url($ruta);
    }
    return array('url' => $url, 'title' => $titulo, 'target' => $target);
}

/** Renderiza un enlace con las clases aprobadas, si hay destino válido. */
function eleam_inicio_boton($enlace, $clase = 'boton-secundario') {
    if (!is_array($enlace) || empty($enlace['url']) || empty($enlace['title'])) {
        return;
    }
    $target = isset($enlace['target']) && $enlace['target'] === '_blank' ? '_blank' : '_self';
    $rel = $target === '_blank' ? ' rel="noopener noreferrer"' : '';
    ?>
    <a class="btn boton <?php echo esc_attr($clase); ?>"
       href="<?php echo esc_url($enlace['url']); ?>"
       <?php if ($target === '_blank'): ?>target="_blank"<?php echo $rel; ?><?php endif; ?>>
        <?php echo esc_html($enlace['title']); ?> <span class="bi bi-arrow-right" aria-hidden="true"></span>
    </a>
    <?php
}

/** Obtiene HTML de imagen SCF, con soporte para ID, array y URL. */
function eleam_inicio_imagen($valor, $clases = '', $alt_respaldo = '', $tamano = 'large', $carga = 'lazy') {
    $id = 0;
    $url = '';
    $alt = $alt_respaldo;

    if (is_array($valor)) {
        $id = isset($valor['ID']) ? (int) $valor['ID'] : (isset($valor['id']) ? (int) $valor['id'] : 0);
        $url = !empty($valor['url']) ? (string) $valor['url'] : '';
        if (!empty($valor['alt'])) {
            $alt = (string) $valor['alt'];
        }
    } elseif (is_numeric($valor)) {
        $id = (int) $valor;
    } elseif (is_string($valor)) {
        $url = $valor;
    }

    $atributos = array(
        'class' => $clases,
        'loading' => $carga,
        'decoding' => 'async',
    );
    if ($carga === 'eager') {
        $atributos['fetchpriority'] = 'high';
    }
    if ($id > 0 && wp_attachment_is_image($id)) {
        if (get_post_meta($id, '_wp_attachment_image_alt', true) === '') {
            $atributos['alt'] = $alt;
        }
        return wp_get_attachment_image($id, $tamano, false, $atributos);
    }
    if (!$url || !wp_http_validate_url($url)) {
        return '';
    }
    return '<img src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '" class="' . esc_attr($clases) . '" loading="' . esc_attr($carga) . '" decoding="async">';
}

/** ID de la página Contacto, para reutilizar sus datos SCF en Inicio. */
function eleam_inicio_contacto_id() {
    static $id = null;
    if ($id === null) {
        $pagina = get_page_by_path('contacto');
        $id = $pagina instanceof WP_Post ? (int) $pagina->ID : 0;
    }
    return $id;
}

/** Busca el formulario ya creado en Contact Form 7 sin fijar IDs de otro entorno. */
function eleam_inicio_formulario_cf7() {
    if (!shortcode_exists('contact-form-7') || !post_type_exists('wpcf7_contact_form')) {
        return '';
    }
    $formulario = get_page_by_path('formulario-de-contacto-1', OBJECT, 'wpcf7_contact_form');
    if (!($formulario instanceof WP_Post)) {
        $formularios = get_posts(array(
            'post_type' => 'wpcf7_contact_form',
            'post_status' => 'publish',
            'numberposts' => 1,
            'orderby' => 'ID',
            'order' => 'ASC',
        ));
        $formulario = $formularios ? $formularios[0] : null;
    }
    if (!($formulario instanceof WP_Post)) {
        return '';
    }
    return do_shortcode('[contact-form-7 id="' . (int) $formulario->ID . '"]');
}

/** Encola únicamente el CSS complementario de Inicio. */
function eleam_inicio_encolar_css() {
    if (!is_page_template('page-index.php')) {
        return;
    }
    $relativo = '/assets/librerias/css/inicio.css';
    wp_enqueue_style(
        'eleam-inicio',
        get_template_directory_uri() . $relativo,
        array('componentes-css'),
        file_exists(get_template_directory() . $relativo) ? (string) filemtime(get_template_directory() . $relativo) : null
    );
}
add_action('wp_enqueue_scripts', 'eleam_inicio_encolar_css', 30);
