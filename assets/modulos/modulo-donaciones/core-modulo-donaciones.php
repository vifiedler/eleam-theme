<?php
function registrar_cpt_donaciones()
{

    $labels = array(
        'name' => 'Donaciones',
        'singular_name' => 'donaciones',
        'menu_name' => 'donaciones',
        'name_admin_bar' => 'donaciones',
        'add_new' => 'Añadir nuevo',
        'add_new_item' => 'Añadir nueva donaciones',
        'new_item' => 'Nuevo donaciones',
        'edit_item' => 'Editar donaciones',
        'view_item' => 'Ver donaciones',
        'all_items' => 'Todas las donaciones',
        'search_items' => 'Buscar donaciones',
        'not_found' => 'No se encontraron donaciones',
        'not_found_in_trash' => 'No se encontraron donaciones en la papelera',
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
        'rewrite' => array('slug' => 'donaciones'),
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
        'menu_position' => 5,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
    );

    register_post_type('donaciones', $args);
}
add_action('init', 'registrar_cpt_donaciones');
