<?php
function registrar_cpt_capellania()
{

    $labels = array(
        'name' => 'Capellanía',
        'singular_name' => 'capellania',
        'menu_name' => 'capellania',
        'name_admin_bar' => 'capellania',
        'add_new' => 'Añadir nuevo',
        'add_new_item' => 'Añadir nueva capellania',
        'new_item' => 'Nuevo capellania',
        'edit_item' => 'Editar capellania',
        'view_item' => 'Ver capellania',
        'all_items' => 'Todas las capellania',
        'search_items' => 'Buscar capellania',
        'not_found' => 'No se encontraron capellania',
        'not_found_in_trash' => 'No se encontraron capellania en la papelera',
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
        'rewrite' => array('slug' => 'capellania'),
        'scapellania_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
        'menu_position' => 5,
        'publicly_queryable' => true,
        'scapellania_ui' => true,
        'scapellania_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
    );

    register_post_type('capellania', $args);
}
add_action('init', 'registrar_cpt_capellania');