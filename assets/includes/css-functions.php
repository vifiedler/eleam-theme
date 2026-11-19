<?php
function eleam_theme_calendario_liturgico_assets()
{
    if (!is_page('capellania')) {
        return;
    }

    wp_enqueue_style(
        'slick',
        'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css',
        array(),
        '1.8.1'
    );

    wp_enqueue_script(
        'slick',
        'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js',
        array('jquery'),
        '1.8.1',
        true
    );

    wp_enqueue_script(
        'eleam-calendario-liturgico',
        get_template_directory_uri() . '/assets/js/calendario-liturgico.js',
        array('jquery', 'slick'),
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'eleam_theme_calendario_liturgico_assets');