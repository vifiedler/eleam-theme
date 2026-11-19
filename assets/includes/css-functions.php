<?php
function css_functions()
{
    wp_register_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css', array(), null, 'all');
    wp_register_style('bootstrap-icon', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css', array(), null, 'all');  
    wp_register_style('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), null, 'all');
    wp_register_style('general', get_template_directory_uri() . '/assets/librerias/css/general.css', array(), null, 'all');
    wp_register_style('footer-css', get_template_directory_uri() . '/assets/templates/footers/footer.css', array('componentes-css'), null, 'all');
    wp_register_style('capellania-css', get_template_directory_uri() . '/assets/librerias/css/capellania.css', array(), null, 'all');
    wp_register_style('actividades-css', get_template_directory_uri() . '/assets/librerias/css/actividades.css', array(), null, 'all');
    wp_register_style('catalogo-css', get_template_directory_uri() . '/assets/librerias/css/catalogo.css', array(), null, 'all');
    wp_register_style('componentes-css', get_template_directory_uri() . '/assets/librerias/css/componentes.css', array(), null, 'all');
    wp_register_style('donaciones-css', get_template_directory_uri() . '/assets/librerias/css/donaciones.css', array(), null, 'all');


    wp_enqueue_style('bootstrap');
    wp_enqueue_style('bootstrap-icon');
    wp_enqueue_style('slick');
    wp_enqueue_style('general');
    wp_enqueue_style('footer-css');
    wp_enqueue_style('capellania-css');
    wp_enqueue_style('actividades-css');
    wp_enqueue_style('catalogo-css');
    wp_enqueue_style('componentes-css');
    wp_enqueue_style('donaciones-css');


}
add_action('wp_enqueue_scripts', 'css_functions'); 
