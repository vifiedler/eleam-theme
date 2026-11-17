<?php
function registrar_cpt_actividades()
{

    $labels = array(
        'name' => 'Actividades',
        'singular_name' => 'actividades',
        'menu_name' => 'actividades',
        'name_admin_bar' => 'actividades',
        'add_new' => 'Añadir nuevo',
        'add_new_item' => 'Añadir nueva actividades',
        'new_item' => 'Nuevo actividades',
        'edit_item' => 'Editar actividades',
        'view_item' => 'Ver actividades',
        'all_items' => 'Todas las actividades',
        'search_items' => 'Buscar actividades',
        'not_found' => 'No se encontraron actividades',
        'not_found_in_trash' => 'No se encontraron actividades en la papelera',
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
        'rewrite' => array('slug' => 'actividades'),
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
        'menu_position' => 5,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
    );

    register_post_type('actividades', $args);
}
add_action('init', 'registrar_cpt_actividades');
