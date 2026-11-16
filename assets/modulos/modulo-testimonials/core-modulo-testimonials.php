<?php
function registrar_cpt_testimonials()
{

    $labels = array(
        'name' => 'testimonials',
        'singular_name' => 'testimonials',
        'menu_name' => 'testimonials',
        'name_admin_bar' => 'testimonials',
        'add_new' => 'Añadir nuevo',
        'add_new_item' => 'Añadir nueva testimonials',
        'new_item' => 'Nuevo testimonials',
        'edit_item' => 'Editar testimonials',
        'view_item' => 'Ver testimonials',
        'all_items' => 'Todas las testimonials',
        'search_items' => 'Buscar testimonials',
        'not_found' => 'No se encontraron testimonials',
        'not_found_in_trash' => 'No se encontraron testimonials en la papelera',
        'featured_image' => 'Imagen destacada',
        'set_featured_image' => 'Asignar imagen destacada',
        'remove_featured_image' => 'Quitar imagen destacada',
        'use_featured_image' => 'Usar como imagen destacada',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-edit',
        'rewrite' => array('slug' => 'testimonials'),
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
        'menu_position' => 5,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
    );

    register_post_type('testimonials', $args);
}
add_action('init', 'registrar_cpt_testimonials');
