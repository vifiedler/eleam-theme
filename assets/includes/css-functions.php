<?php
function css_functions()
{
    wp_register_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css', 'all');
    wp_register_style('bootstrap-icon', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css', 'all');
    wp_register_style('fuente-nova', 'https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;display=swap', 'all');

    wp_register_style('glightbox', get_template_directory_uri() . '/assets/includes/vendors/glightbox/glightbox.min.css', 'all');
    wp_register_style('swiper', get_template_directory_uri() . '/assets/includes/vendors/swiper/swiper-bundle.min.css', 'all');
    wp_register_style('aos', get_template_directory_uri() . '/assets/includes/vendors/aos/aos.css', 'all');
    wp_register_style('estilo-nova', get_template_directory_uri() . '/assets/librerias/css/style.css', 'all');
    wp_register_style('footer-css', get_template_directory_uri() . '/assets/templates/footers/footer.css', 'all');

    wp_enqueue_style('footer-css');
    wp_enqueue_style('fuente-nova');
    wp_enqueue_style('bootstrap');
    wp_enqueue_style('bootstrap-icon');
    wp_enqueue_style('glightbox');
    wp_enqueue_style('swiper');
    wp_enqueue_style('aos');
    wp_enqueue_style('estilo-nova');

}
add_action('wp_enqueue_scripts', 'css_functions');