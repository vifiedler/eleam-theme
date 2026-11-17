<?php
function registrar_cpt_infraestructura()
{

    $labels = array(
        'name' => 'Infraestructura',
        'singular_name' => 'infraestructura',
        'menu_name' => 'infraestructura',
        'name_admin_bar' => 'infraestructura',
        'add_new' => 'Añadir nuevo',
        'add_new_item' => 'Añadir nueva infraestructura',
        'new_item' => 'Nuevo infraestructura',
        'edit_item' => 'Editar infraestructura',
        'view_item' => 'Ver infraestructura',
        'all_items' => 'Todas las infraestructura',
        'search_items' => 'Buscar infraestructura',
        'not_found' => 'No se encontraron infraestructura',
        'not_found_in_trash' => 'No se encontraron infraestructura en la papelera',
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
        'rewrite' => array('slug' => 'infraestructura'),
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
        'menu_position' => 5,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
    );

    register_post_type('infraestructura', $args);
}
add_action('init', 'registrar_cpt_infraestructura');
