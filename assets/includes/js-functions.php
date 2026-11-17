<?php
function js_function()
{
    if (!(is_admin())) {
        wp_register_script('bootstrap-js', get_template_directory_uri() . '/assets/includes/vendors/bootstrap/bootstrap.bundle.min.js', array(), null, true);
        wp_register_script('gsap-js', get_template_directory_uri() . '/assets/includes/vendors/gsap/gsap.min.js', array(), null, true);
        wp_register_script('calendario-js', get_template_directory_uri() . '/assets/librerias/js/calendario.js', array(), null, true);
        wp_register_script('capellania-js', get_template_directory_uri() . '/assets/librerias/js/capellania.js', array(), null, true);
        wp_register_script('donaciones-js', get_template_directory_uri() . '/assets/librerias/js/donaciones.js', array(), null, true);
        wp_register_script('galeria-js', get_template_directory_uri() . '/assets/librerias/js/galeria.js', array(), null, true);
        wp_register_script('inicio-js', get_template_directory_uri() . '/assets/librerias/js/inicio.js', array(), null, true);
  
  

        wp_enqueue_script('bootstrap-js');
        wp_enqueue_script('gsap-js');
        wp_enqueue_script('calendario-js');
        wp_enqueue_script('capellania-js');
        wp_enqueue_script('donaciones-js');
        wp_enqueue_script('galeria-js');
        wp_enqueue_script('inicio-js');
    }
}
add_action("wp_enqueue_scripts", "js_function", 999);