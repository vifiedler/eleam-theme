<?php
function registrar_cpt_quienes_somos()
{

    $labels = array(
        'name' => 'Quienes Somos',
        'singular_name' => 'quienes_somos',
        'menu_name' => 'quienes_somos',
        'name_admin_bar' => 'quienes_somos',
        'add_new' => 'Añadir nuevo',
        'add_new_item' => 'Añadir nueva quienes_somos',
        'new_item' => 'Nuevo quienes_somos',
        'edit_item' => 'Editar quienes_somos',
        'view_item' => 'Ver quienes_somos',
        'all_items' => 'Todas las quienes_somos',
        'search_items' => 'Buscar quienes_somos',
        'not_found' => 'No se encontraron quienes_somos',
        'not_found_in_trash' => 'No se encontraron quienes_somos en la papelera',
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
        'rewrite' => array('slug' => 'quienes_somos'),
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
        'menu_position' => 5,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
    );

    register_post_type('quienes_somos', $args);
}
add_action('init', 'registrar_cpt_quienes_somos');
