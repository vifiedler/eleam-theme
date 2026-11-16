<?php
function registrar_cpt_pricing()
{

    $labels = array(
        'name' => 'pricing',
        'singular_name' => 'pricing',
        'menu_name' => 'pricing',
        'name_admin_bar' => 'pricing',
        'add_new' => 'Añadir nuevo',
        'add_new_item' => 'Añadir nueva pricing',
        'new_item' => 'Nuevo pricing',
        'edit_item' => 'Editar pricing',
        'view_item' => 'Ver pricing',
        'all_items' => 'Todas las pricing',
        'search_items' => 'Buscar pricing',
        'not_found' => 'No se encontraron pricing',
        'not_found_in_trash' => 'No se encontraron pricing en la papelera',
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
        'rewrite' => array('slug' => 'pricing'),
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
        'menu_position' => 5,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
    );

    register_post_type('pricing', $args);
}
add_action('init', 'registrar_cpt_pricing');