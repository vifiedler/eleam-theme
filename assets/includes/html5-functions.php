<?php
/**
 * Serialización HTML5 del documento público.
 *
 * WordPress y algunos complementos generan todavía etiquetas vacías con
 * sintaxis XHTML (por ejemplo <img /> y <link />). El cierre " />" no es
 * necesario en text/html y provoca avisos informativos en Nu Validator.
 *
 * Se normaliza únicamente la respuesta HTML del tema, sin editar el núcleo
 * de WordPress, el marcado de los complementos ni los endpoints REST/AJAX.
 * Se excluyen scripts, estilos, comentarios y contenido de texto sin formato.
 *
 * @package eleam-theme
 */

defined('ABSPATH') || exit;

/**
 * Quita el slash final únicamente a elementos vacíos de HTML5.
 * No modifica elementos SVG, MathML, ni texto crudo de script/style/etc.
 *
 * @param string $html Salida HTML completa del documento.
 * @return string
 */
function eleam_html5_normalizar_etiquetas_vacias($html)
{
    if (!is_string($html) || $html === '' || strpos($html, '/>') === false) {
        return $html;
    }

    // Evitar modificar contenido que no corresponde a una página HTML.
    foreach (headers_list() as $cabecera) {
        if (stripos($cabecera, 'Content-Type:') === 0 && stripos($cabecera, 'text/html') === false) {
            return $html;
        }
    }

    // Tokenizar etiquetas completas antes de evaluar su nombre evita que un
    // fragmento como data-code="<img />" sea tratado como una imagen real.
    // Las regiones de texto sin formato y los comentarios se preservan enteros.
    $patron = '~<!--.*?-->'
        . '|<(?:script|style|textarea|title|template|noscript)\b(?:[^<>"\']|"[^"]*"|\'[^\']*\')*>.*?</(?:script|style|textarea|title|template|noscript)\s*>'
        . '|<(?P<etiqueta>[a-z][a-z0-9:-]*)\b(?:[^<>"\']|"[^"]*"|\'[^\']*\')*>~is';

    $etiquetas_vacias = array_flip(array(
        'area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input',
        'link', 'meta', 'param', 'source', 'track', 'wbr',
    ));

    $resultado = preg_replace_callback(
        $patron,
        static function ($coincidencia) use ($etiquetas_vacias) {
            if (empty($coincidencia['etiqueta'])
                || !isset($etiquetas_vacias[strtolower($coincidencia['etiqueta'])])
                || !preg_match('~/\s*>$~', $coincidencia[0])) {
                return $coincidencia[0];
            }
            return preg_replace('~\s*/\s*>$~', '>', $coincidencia[0]);
        },
        $html
    );

    return is_string($resultado) ? $resultado : $html;
}

/**
 * Inicia el búfer cuando el tema prepara su cabecera HTML. De este modo
 * no se intervienen las solicitudes de administración, REST, Ajax ni feeds.
 */
function eleam_html5_iniciar_normalizacion()
{
    if (is_admin() || wp_doing_ajax() || is_feed() || is_robots() || is_trackback()
        || (defined('REST_REQUEST') && REST_REQUEST)) {
        return;
    }

    ob_start('eleam_html5_normalizar_etiquetas_vacias');
}
add_action('get_header', 'eleam_html5_iniciar_normalizacion', 0);
