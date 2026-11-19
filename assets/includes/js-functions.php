<?php
function js_function()
{
    if (!(is_admin())) {
        $bootstrap_local = '/assets/includes/vendors/bootstrap/bootstrap.bundle.min.js';
        $bootstrap_url = file_exists(get_template_directory() . $bootstrap_local)
            ? get_template_directory_uri() . $bootstrap_local
            : 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js';
        wp_register_script('bootstrap-js', $bootstrap_url, array(), '5.3.8', true);
        wp_register_script('slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.8.1', true);
        wp_register_script('gsap-js', get_template_directory_uri() . '/assets/includes/vendors/gsap/gsap.min.js', array(), null, true);
        wp_register_script('calendario-js', get_template_directory_uri() . '/assets/librerias/js/calendario.js', array(), null, true);
        wp_register_script('capellania-js', get_template_directory_uri() . '/assets/librerias/js/capellania.js', array('bootstrap-js'), null, true);
        wp_register_script('donaciones-js', get_template_directory_uri() . '/assets/librerias/js/donaciones.js', array(), null, true);
        wp_register_script('galeria-js', get_template_directory_uri() . '/assets/librerias/js/galeria.js', array('jquery', 'slick-js'), null, true);
        wp_register_script('inicio-js', get_template_directory_uri() . '/assets/librerias/js/inicio.js', array('jquery', 'slick-js'), null, true);
        wp_register_script('actividades-js', get_template_directory_uri() . '/assets/librerias/js/actividades.js', array(), null, true);
  
  

        wp_enqueue_script('bootstrap-js');
        wp_enqueue_script('calendario-js');
        wp_enqueue_script('capellania-js');
        wp_enqueue_script('donaciones-js');
        wp_enqueue_script('galeria-js');
        wp_enqueue_script('inicio-js');
        wp_enqueue_script('actividades-js');
    }
}
add_action("wp_enqueue_scripts", "js_function", 999);