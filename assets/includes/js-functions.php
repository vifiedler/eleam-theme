<?php
function js_function()
{
    if (!(is_admin())) {
        wp_register_script('bootstrap-js', get_template_directory_uri() . '/assets/includes/vendors/bootstrap/bootstrap.bundle.min.js', array(), null, true);
        wp_register_script('gsap-js', get_template_directory_uri() . '/assets/includes/vendors/gsap/gsap.min.js', array(), null, true);
        wp_register_script('imagesloaded-js', get_template_directory_uri() . '/assets/includes/vendors/imagesloaded/imagesloaded.pkgd.min.js', array(), null, true);
        wp_register_script('isotope-js', get_template_directory_uri() . '/assets/includes/vendors/isotope/isotope.pkgd.min.js', array(), null, true);
        wp_register_script('glightbox-js', get_template_directory_uri() . '/assets/includes/vendors/glightbox/glightbox.min.js', array(), null, true);
        wp_register_script('swiper-js', get_template_directory_uri() . '/assets/includes/vendors/swiper/swiper-bundle.min.js', array(), null, true);
        wp_register_script('aos-js', get_template_directory_uri() . '/assets/includes/vendors/aos/aos.js', array(), null, true);
        wp_register_script('purecounter-js', get_template_directory_uri() . '/assets/includes/vendors/purecounter/purecounter.js', array(), null, true);
        wp_register_script('custom-js', get_template_directory_uri() . '/assets/librerias/js/custom.js', array(), null, true);
        wp_register_script('send-email-js', get_template_directory_uri() . '/assets/librerias/js/send_email.js', array(), null, true);

        wp_enqueue_script('bootstrap-js');
        wp_enqueue_script('gsap-js');
        wp_enqueue_script('imagesloaded-js');
        wp_enqueue_script('isotope-js');
        wp_enqueue_script('glightbox-js');
        wp_enqueue_script('swiper-js');
        wp_enqueue_script('aos-js');
        wp_enqueue_script('purecounter-js');
        wp_enqueue_script('custom-js');
        wp_enqueue_script('send-email-js');
    }
}
add_action("wp_enqueue_scripts", "js_function", 999);