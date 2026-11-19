<?php

function cargar_estilos_para_menus()
{
    // Registrar la hoja de estilo
    wp_register_style('estilos-menus', get_template_directory_uri() . '/assets/templates/navs/nav.css', array('general'), filemtime(get_template_directory() . '/assets/templates/navs/nav.css'), 'all');

    wp_enqueue_style('estilos-menus');

    // Interacción accesible y localizada del desplegable del Walker ELEAM.
    $script_nav = get_template_directory() . '/assets/templates/navs/nav.js';
    if (file_exists($script_nav)) {
        wp_enqueue_script(
            'eleam-nav-desplegable',
            get_template_directory_uri() . '/assets/templates/navs/nav.js',
            array(),
            filemtime($script_nav),
            true
        );
    }
}

// Añadir la acción al hook 'wp_enqueue_scripts' que es el adecuado para encolar estilos y scripts
add_action('wp_enqueue_scripts', 'cargar_estilos_para_menus');



/*customizar la clase y el link del logo de wordpress*/
function add_class_to_custom_logo()
{
    $custom_logo_id = get_theme_mod('custom_logo');
    $html = sprintf(
        '<a href="%1$s" class="col-12 col-md-2 navbar-brand p-0" rel="home" itemprop="url">%2$s</a>',
        esc_url(home_url('/')),
        wp_get_attachment_image($custom_logo_id, 'full', false, array(
            'class' => 'img-fluid',
        ))
    );
    return $html;
}
add_filter('get_custom_logo', 'add_class_to_custom_logo');
/*customizar la clase y el link del logo de wordpress*/




/*menu superior*/
if (!function_exists('menu_superior')) {
    // Register Navigation Menus
    function menu_superior()
    {

        $locations = array(
            'menu-superior' => __('menu-superior', 'menu-superior'),
        );
        register_nav_menus($locations);
    }
    add_action('init', 'menu_superior');
}

/*clases para li item */
function atg_menu_classes($classes, $item, $args)
{
    if ($args->theme_location == 'menu-superior') {
        $classes[] = 'nav-item';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'atg_menu_classes', 1, 3);
/*clases para li item */

/*menu superior*/



/*menu mobile*/
// Register Navigation Menus
function menu_mobile()
{

    $locations = array(
        'menu-mobile' => __('menu-mobile', 'menu-mobile'),
    );
    register_nav_menus($locations);
}
add_action('init', 'menu_mobile');
/*menu mobile*/


/*menu wordpress*/
class bootstrap_5_wp_nav_menu_walker extends Walker_Nav_Menu
{

    private $dropdown_icon = '<i class="bi bi-chevron-down"></i>';

    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $submenu = ($depth > 0) ? ' sub-menu' : '';
        $output .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\">\n";
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'nav-item';
        if ($args->walker->has_children) {
            $classes[] = 'dropdown';
        }
        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'active';
        }
        $classes = array_filter($classes);
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names . '>';

        $atts = array();
        $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
        $atts['href'] = !empty($item->url) ? $item->url : '';

        if ($args->walker->has_children) {
            $atts['data-bs-toggle'] = 'dropdown';
            $atts['class'] = 'nav-link dropdown-toggle';
            $atts['aria-expanded'] = 'false';
        } else {
            $atts['class'] = 'nav-link';
        }

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= ($args->walker->has_children) ? ' ' . $this->dropdown_icon : '';
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}
/*menu wordpress*/

/**
 * Ubicación del menú conservada del WordPress actual y su exportación WXR.
 * El contenido sigue administrándose en Apariencia > Menús, pero el marcado
 * completo lo produce el Walker del tema.
 */
function eleam_registrar_navegacion_principal() {
    register_nav_menus( array( 'menu-nav' => __( 'Navegación principal ELEAM', 'eleam-theme' ) ) );
}
add_action( 'after_setup_theme', 'eleam_registrar_navegacion_principal', 11 );

/**
 * Walker ELEAM. El elemento de menú con hijos se presenta como un disclosure
 * nativo (<details>/<summary>), no como enlace a una página.
 * No depende de JavaScript externo para mostrar las opciones.
 */
class ELEAM_Nav_Walker extends Walker_Nav_Menu {
    private $ids_padres = array();
    private $elementos_con_hijos = array();

    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $parent_id = isset( $this->ids_padres[ $depth ] ) ? $this->ids_padres[ $depth ] : 0;
        $output .= "\n<ul class=\"navegacion-submenu\" aria-labelledby=\"eleam-dropdown-" . esc_attr( $parent_id ) . "\">\n";
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $output .= "</ul>\n";
    }

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $tiene_hijos = ! empty( $args->has_children );
        $this->elementos_con_hijos[ (int) $item->ID ] = $tiene_hijos;
        $clases = array_filter( (array) $item->classes );
        $clases[] = 'nav-item';

        if ( $tiene_hijos ) {
            $clases[] = 'navegacion-secundaria';
            $this->ids_padres[ $depth ] = (int) $item->ID;
        }

        $es_contribuye = ! $tiene_hijos && 0 === $depth
            && 'contribuye' === sanitize_title( $item->title );

        if ( $es_contribuye ) {
            $clases[] = 'navegacion-accion';
        }

        $clases = apply_filters( 'nav_menu_css_class', $clases, $item, $args, $depth );
        $clases = array_unique( array_filter( array_map( 'sanitize_html_class', $clases ) ) );
        $output .= '<li class="' . esc_attr( implode( ' ', $clases ) ) . '">';

        $titulo = apply_filters( 'the_title', $item->title, $item->ID );
        $titulo_html = '<span class="navegacion-texto" data-texto="' . esc_attr( wp_strip_all_tags( $titulo ) ) . '">'
            . esc_html( $titulo ) . '</span>';

        if ( $tiene_hijos ) {
            // <summary> abre/cierra el menú; el elemento padre no tiene href.
            $output .= '<details class="navegacion-desplegable">'
                . '<summary id="eleam-dropdown-' . esc_attr( $item->ID ) . '" class="nav-link navegacion-disparador">'
                . $titulo_html
                . '<span class="bi bi-chevron-down" aria-hidden="true"></span>'
                . '</summary>';
            return;
        }

        $es_actual = in_array( 'current-menu-item', $clases, true )
            || in_array( 'current_page_item', $clases, true );

        $atributos = array(
            'class' => $es_contribuye
                ? 'btn boton boton-primario'
                : ( $depth > 0 ? 'dropdown-item' : 'nav-link' ),
            'href' => ! empty( $item->url ) ? $item->url : '',
        );
        if ( $es_actual ) {
            $atributos['aria-current'] = 'page';
        }
        if ( ! empty( $item->target ) ) {
            $atributos['target'] = $item->target;
        }
        if ( ! empty( $item->xfn ) ) {
            $atributos['rel'] = $item->xfn;
        }
        if ( ! empty( $item->attr_title ) ) {
            $atributos['title'] = $item->attr_title;
        }
        $atributos = apply_filters( 'nav_menu_link_attributes', $atributos, $item, $args, $depth );
        $output .= '<a';
        foreach ( $atributos as $nombre => $valor ) {
            if ( null === $valor || '' === $valor || false === $valor ) {
                continue;
            }
            $valor = 'href' === $nombre ? esc_url( $valor ) : esc_attr( $valor );
            $output .= ' ' . esc_attr( $nombre ) . '="' . $valor . '"';
        }
        $output .= '>' . $titulo_html;
        if ( $es_contribuye ) {
            $output .= '<span class="bi bi-arrow-right" aria-hidden="true"></span>';
        }
        $output .= '</a>';
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $item_id = (int) $item->ID;
        if ( ! empty( $this->elementos_con_hijos[ $item_id ] ) ) {
            $output .= '</details>';
        }
        unset( $this->elementos_con_hijos[ $item_id ] );
        $output .= "</li>\n";
    }
}
