<?php
function registrar_cpt_contacto()
{

    $labels = array(
        'name' => 'Contacto',
        'singular_name' => 'contacto',
        'menu_name' => 'contacto',
        'name_admin_bar' => 'contacto',
        'add_new' => 'Añadir nuevo',
        'add_new_item' => 'Añadir nueva contacto',
        'new_item' => 'Nuevo contacto',
        'edit_item' => 'Editar contacto',
        'view_item' => 'Ver contacto',
        'all_items' => 'Todas las contacto',
        'search_items' => 'Buscar contacto',
        'not_found' => 'No se encontraron contacto',
        'not_found_in_trash' => 'No se encontraron contacto en la papelera',
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
        'rewrite' => array('slug' => 'contacto'),
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
        'menu_position' => 5,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
    );

    register_post_type('contacto', $args);
}
add_action('init', 'registrar_cpt_contacto');