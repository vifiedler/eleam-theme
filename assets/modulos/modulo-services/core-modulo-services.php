<?php
function registrar_cpt_services()
{

    $labels = array(
        'name' => 'services',
        'singular_name' => 'services',
        'menu_name' => 'services',
        'name_admin_bar' => 'services',
        'add_new' => 'Añadir nuevo',
        'add_new_item' => 'Añadir nueva services',
        'new_item' => 'Nuevo services',
        'edit_item' => 'Editar services',
        'view_item' => 'Ver services',
        'all_items' => 'Todas las services',
        'search_items' => 'Buscar services',
        'not_found' => 'No se encontraron services',
        'not_found_in_trash' => 'No se encontraron services en la papelera',
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
        'rewrite' => array('slug' => 'services'),
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
        'menu_position' => 5,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
    );

    register_post_type('services', $args);
}
add_action('init', 'registrar_cpt_services');