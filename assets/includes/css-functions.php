<?php

/**
 * Registra y carga las hojas de estilo compartidas del tema.
 */
function eleam_theme_css()
{
    if (is_admin()) {
        return;
    }

    wp_register_style(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css',
        array(),
        '5.3.8',
        'all'
    );
    wp_register_style(
        'bootstrap-icon',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css',
        array(),
        '1.13.1',
        'all'
    );
    wp_register_style(
        'slick',
        'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css',
        array(),
        '1.8.1',
        'all'
    );

    wp_register_style(
        'general',
        get_template_directory_uri() . '/assets/librerias/css/general.css',
        array('bootstrap'),
        file_exists(get_template_directory() . '/assets/librerias/css/general.css')
            ? (string) filemtime(get_template_directory() . '/assets/librerias/css/general.css')
            : null,
        'all'
    );
    wp_register_style(
        'componentes-css',
        get_template_directory_uri() . '/assets/librerias/css/componentes.css',
        array('general'),
        file_exists(get_template_directory() . '/assets/librerias/css/componentes.css')
            ? (string) filemtime(get_template_directory() . '/assets/librerias/css/componentes.css')
            : null,
        'all'
    );

    wp_register_style(
        'footer-css',
        get_template_directory_uri() . '/assets/templates/footers/footer.css',
        array('general'),
        file_exists(get_template_directory() . '/assets/templates/footers/footer.css')
            ? (string) filemtime(get_template_directory() . '/assets/templates/footers/footer.css')
            : null,
        'all'
    );

    wp_register_style(
        'capellania-css',
        get_template_directory_uri() . '/assets/librerias/css/capellania.css',
        array('componentes-css'),
        file_exists(get_template_directory() . '/assets/librerias/css/capellania.css')
            ? (string) filemtime(get_template_directory() . '/assets/librerias/css/capellania.css')
            : null,
        'all'
    );

    wp_enqueue_style('bootstrap');
    wp_enqueue_style('bootstrap-icon');
    wp_enqueue_style('slick');
    wp_enqueue_style('general');
    wp_enqueue_style('componentes-css');
    wp_enqueue_style('footer-css');
    wp_enqueue_style('capellania-css');
}
add_action('wp_enqueue_scripts', 'eleam_theme_css', 5);
