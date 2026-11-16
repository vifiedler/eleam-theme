<?php
function registrar_cpt_faq()
{

    $labels = array(
        'name' => 'faq',
        'singular_name' => 'faq',
        'menu_name' => 'faq',
        'name_admin_bar' => 'faq',
        'add_new' => 'Añadir nuevo',
        'add_new_item' => 'Añadir nueva faq',
        'new_item' => 'Nuevo faq',
        'edit_item' => 'Editar faq',
        'view_item' => 'Ver faq',
        'all_items' => 'Todas las faq',
        'search_items' => 'Buscar faq',
        'not_found' => 'No se encontraron faq',
        'not_found_in_trash' => 'No se encontraron faq en la papelera',
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
        'rewrite' => array('slug' => 'faq'),
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
        'menu_position' => 5,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
    );

    register_post_type('faq', $args);
}
add_action('init', 'registrar_cpt_faq');