<?php
function registrar_cpt_transparencia()
{

    $labels = array(
        'name' => 'Transparencia',
        'singular_name' => 'transparencia',
        'menu_name' => 'transparencia',
        'name_admin_bar' => 'transparencia',
        'add_new' => 'Añadir nuevo',
        'add_new_item' => 'Añadir nueva transparencia',
        'new_item' => 'Nuevo transparencia',
        'edit_item' => 'Editar transparencia',
        'view_item' => 'Ver transparencia',
        'all_items' => 'Todas las transparencia',
        'search_items' => 'Buscar transparencia',
        'not_found' => 'No se encontraron transparencia',
        'not_found_in_trash' => 'No se encontraron transparencia en la papelera',
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
        'rewrite' => array('slug' => 'transparencia'),
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
        'menu_position' => 5,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
    );

    register_post_type('transparencia', $args);
}
add_action('init', 'registrar_cpt_transparencia');