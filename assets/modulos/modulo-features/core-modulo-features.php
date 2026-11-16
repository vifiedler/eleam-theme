<?php
function registrar_cpt_features()
{

    $labels = array(
        'name' => 'features',
        'singular_name' => 'features',
        'menu_name' => 'features',
        'name_admin_bar' => 'features',
        'add_new' => 'Añadir nuevo',
        'add_new_item' => 'Añadir nueva features',
        'new_item' => 'Nuevo features',
        'edit_item' => 'Editar features',
        'view_item' => 'Ver features',
        'all_items' => 'Todas las features',
        'search_items' => 'Buscar features',
        'not_found' => 'No se encontraron features',
        'not_found_in_trash' => 'No se encontraron features en la papelera',
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
        'rewrite' => array('slug' => 'features'),
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
        'menu_position' => 5,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
    );

    register_post_type('features', $args);
}
add_action('init', 'registrar_cpt_features');
