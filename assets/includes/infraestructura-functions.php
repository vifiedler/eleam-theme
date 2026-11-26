<?php
/** Utilidades específicas de la página Infraestructura. */
defined('ABSPATH') || exit;

/** Recupera únicamente fotografías válidas. No inventa datos ni edita SCF. */
function eleam_infraestructura_fotografias() {
    $filas = eleam_inicio_campo('galeria_infraestructura', false, array());
    if (!is_array($filas)) {
        return array();
    }
    $fotografias = array();
    foreach ($filas as $fila) {
        if (!is_array($fila)) {
            continue;
        }
        $rotulo = isset($fila['nombre_foto']) && is_scalar($fila['nombre_foto']) ? trim((string) $fila['nombre_foto']) : '';
        $descripcion = isset($fila['descripcion_foto']) && is_scalar($fila['descripcion_foto']) ? trim((string) $fila['descripcion_foto']) : '';
        $alt = $rotulo !== '' ? $rotulo : 'Instalaciones del ELEAM';
        $imagen = eleam_inicio_imagen(isset($fila['imagen_infraestructura']) ? $fila['imagen_infraestructura'] : null, 'img-fluid', $alt, 'large', 'lazy');
        if ($imagen === '') {
            continue;
        }
        $fotografias[] = array(
            'rotulo' => $rotulo !== '' ? $rotulo : 'Instalaciones del hogar',
            'descripcion' => $descripcion,
            'imagen' => $imagen,
        );
    }
    return $fotografias;
}

/** Estilos específicos para la última diapositiva cuando contiene menos de 4 imágenes. */
function eleam_infraestructura_encolar_css() {
    if (!is_page_template('page-infraestructura.php')) {
        return;
    }
    $ruta = '/assets/librerias/css/infraestructura.css';
    wp_enqueue_style(
        'eleam-infraestructura',
        get_template_directory_uri() . $ruta,
        array('componentes-css'),
        file_exists(get_template_directory() . $ruta) ? (string) filemtime(get_template_directory() . $ruta) : null
    );
}
add_action('wp_enqueue_scripts', 'eleam_infraestructura_encolar_css', 30);
