<?php
function registrar_cpt_about()
{

    $labels = array(
        'name' => 'about',
        'singular_name' => 'about',
        'menu_name' => 'about',
        'name_admin_bar' => 'about',
        'add_new' => 'Añadir nuevo',
        'add_new_item' => 'Añadir nueva about',
        'new_item' => 'Nuevo about',
        'edit_item' => 'Editar about',
        'view_item' => 'Ver about',
        'all_items' => 'Todas las about',
        'search_items' => 'Buscar about',
        'not_found' => 'No se encontraron about',
        'not_found_in_trash' => 'No se encontraron about en la papelera',
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
        'rewrite' => array('slug' => 'about'),
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
        'menu_position' => 5,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
    );

    register_post_type('about', $args);
}
add_action('init', 'registrar_cpt_about');
