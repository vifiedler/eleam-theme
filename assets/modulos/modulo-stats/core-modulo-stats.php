<?php
function registrar_cpt_stats()
{

    $labels = array(
        'name' => 'stats',
        'singular_name' => 'stats',
        'menu_name' => 'stats',
        'name_admin_bar' => 'stats',
        'add_new' => 'Añadir nuevo',
        'add_new_item' => 'Añadir nueva stats',
        'new_item' => 'Nuevo stats',
        'edit_item' => 'Editar stats',
        'view_item' => 'Ver stats',
        'all_items' => 'Todas las stats',
        'search_items' => 'Buscar stats',
        'not_found' => 'No se encontraron stats',
        'not_found_in_trash' => 'No se encontraron stats en la papelera',
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
        'rewrite' => array('slug' => 'stats'),
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
        'menu_position' => 5,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
    );

    register_post_type('stats', $args);
}
add_action('init', 'registrar_cpt_stats');
