<?php
function registrar_cpt_how()
{

    $labels = array(
        'name' => 'how',
        'singular_name' => 'how',
        'menu_name' => 'how',
        'name_admin_bar' => 'how',
        'add_new' => 'Añadir nuevo',
        'add_new_item' => 'Añadir nueva how',
        'new_item' => 'Nuevo how',
        'edit_item' => 'Editar how',
        'view_item' => 'Ver how',
        'all_items' => 'Todas las how',
        'search_items' => 'Buscar how',
        'not_found' => 'No se encontraron how',
        'not_found_in_trash' => 'No se encontraron how en la papelera',
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
        'rewrite' => array('slug' => 'how'),
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
        'menu_position' => 5,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
    );

    register_post_type('how', $args);
}
add_action('init', 'registrar_cpt_how');