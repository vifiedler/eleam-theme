<?php
/**
 * Santoral de Inicio: calendario propio de Chile, santoral de Vatican News,
 * respaldo JSON existente y biografias/imagenes verificadas en Wikipedia.
 * Sin cambios en WordPress core, CSS o JavaScript.
 *
 * @package eleam-theme
 */

defined('ABSPATH') || exit;

/** Carga solamente los recursos del componente en la plantilla de Inicio. */
function eleam_santoral_encolar_recursos() {
    if (!is_page_template('page-index.php')) {
        return;
    }

    $base = get_template_directory();
    $url  = get_template_directory_uri();
    $css  = '/assets/librerias/css/santoral.css';
    $js   = '/assets/librerias/js/santoral.js';

    wp_enqueue_style(
        'eleam-santoral',
        $url . $css,
        array(),
        file_exists($base . $css) ? (string) filemtime($base . $css) : null
    );
    wp_enqueue_script(
        'eleam-santoral',
        $url . $js,
        array(),
        file_exists($base . $js) ? (string) filemtime($base . $js) : null,
        true
    );
}
add_action('wp_enqueue_scripts', 'eleam_santoral_encolar_recursos');

/**
 * Separa únicamente las comas que enumeran nombres. Conserva los títulos
 * compuestos del santoral, incluido «María, Madre de Dios», y no cambia el JSON.
 */
function eleam_santoral_separar_nombres($valor) {
    $valor = trim((string) $valor);
    if ($valor === '') {
        return array();
    }
    if (preg_match('/^María,\s*Madre de Dios$/iu', $valor)) {
        return array($valor);
    }
    $nombres = array();
    foreach (preg_split('/,(?![^()]*\))/u', $valor) as $parte) {
        $parte = trim($parte);
        if ($parte !== '') {
            $nombres[] = $parte;
        }
    }
    return $nombres;
}

/** Identifica alias contextuales sin cambiar la lista de santos que se muestra. */
function eleam_santoral_titulo_busqueda($nombre) {
    $equivalencias = array(
        'María, Madre de Dios'      => 'María (madre de Jesús)',
        'José'                      => 'José de Nazaret',
        'José Obrero'               => 'San José Obrero',
        'Carmen'                    => 'Virgen del Carmen',
        'N.Sra. de Lourdes'         => 'Nuestra Señora de Lourdes',
        'N.S. Fátima'               => 'Nuestra Señora de Fátima',
        'N. Sra. de Guadalupe'      => 'Nuestra Señora de Guadalupe',
        'N. Sra. del Carmen'        => 'Virgen del Carmen',
        'N. Sra. del Rosario'       => 'Nuestra Señora del Rosario',
        'N. Sra. de Dolores'        => 'Nuestra Señora de los Dolores',
        'N. Sra. de Loreto'         => 'Nuestra Señora de Loreto',
        'María Auxiliadora'         => 'María Auxiliadora',
        'Teresita del Niño Jesús'   => 'Teresa de Lisieux',
        'Teresa de los Andes'       => 'Teresa de Los Andes',
        'Beata Laura Vicuña'        => 'Laura Vicuña',
        'Santa Teresa de Jesús de Los Andes' => 'Teresa de Los Andes',
        'San Alberto Hurtado'      => 'Alberto Hurtado',
        'Santa Rosa de Lima'        => 'Rosa de Lima',
        'Nuestra Señora del Carmen, Madre y Reina de Chile' => 'Virgen del Carmen',
        'Nuestra Señora de la Merced' => 'Nuestra Señora de la Merced',
        'Alberto Hurtado'           => 'Alberto Hurtado',
        'Francisco de Asís'         => 'Francisco de Asís',
        'Inmaculada Concepción'     => 'Inmaculada Concepción',
        'Natividad del Señor (Noel, Noelia)' => 'Nacimiento de Jesús',
        'Todos los Fieles difuntos' => 'Conmemoración de los Fieles Difuntos',
        'Todos los Santos'          => 'Día de Todos los Santos',
        'Presentación del Señor'    => 'Presentación de Jesús en el Templo',
        'Asunción'                  => 'Asunción de María',
        'Visitación'                => 'Visitación de la Virgen María',
        'Anunciación'               => 'Anunciación',
        '(Transfiguración)'         => 'Transfiguración de Jesús',
        'Santiago'                  => 'Santiago el Mayor',
        'Juan Bautista'             => 'Juan el Bautista',
        'Pedro'                     => 'Simón Pedro',
    );
    return isset($equivalencias[$nombre]) ? $equivalencias[$nombre] : $nombre;
}

/** Normaliza sólo para puntuar títulos; el nombre mostrado nunca se reescribe. */
function eleam_santoral_normalizar($cadena) {
    $cadena = strtolower(remove_accents((string) $cadena));
    return trim(preg_replace('/\s+/', ' ', preg_replace('/[^a-z0-9]+/', ' ', $cadena)));
}

/** Llamada controlada al endpoint de Wikipedia en español. */
function eleam_santoral_consultar_api($parametros) {
    $url = add_query_arg(
        array_merge(
            array('action' => 'query', 'format' => 'json', 'formatversion' => '2'),
            $parametros
        ),
        'https://es.wikipedia.org/w/api.php'
    );
    $respuesta = wp_remote_get(
        $url,
        array(
            'timeout' => 4,
            'redirection' => 2,
            'user-agent' => 'ELEAM-Santoral/1.0 (' . home_url('/') . '; WordPress)',
            'headers' => array('Accept' => 'application/json'),
        )
    );
    if (is_wp_error($respuesta) || (int) wp_remote_retrieve_response_code($respuesta) !== 200) {
        return array();
    }
    $datos = json_decode(wp_remote_retrieve_body($respuesta), true);
    return is_array($datos) && !isset($datos['error']) ? $datos : array();
}

/** Valida un artículo y evita atribuir biografías de homónimos no religiosos. */
function eleam_santoral_evaluar_pagina($pagina, $nombre_busqueda, $requiere_contexto = true) {
    if (!is_array($pagina) || !empty($pagina['missing'])) {
        return false;
    }
    $titulo = isset($pagina['title']) ? (string) $pagina['title'] : '';
    $extracto = isset($pagina['extract']) ? trim((string) $pagina['extract']) : '';
    if ($titulo === '' || strlen($extracto) < 35) {
        return false;
    }
    $titulo_normalizado = eleam_santoral_normalizar($titulo);
    $busqueda_normalizada = eleam_santoral_normalizar($nombre_busqueda);
    $palabras = array_filter(explode(' ', $busqueda_normalizada), static function ($palabra) {
        return strlen($palabra) >= 4 && !in_array($palabra, array('santa', 'santo', 'senora', 'madre', 'nuestra', 'cristo'), true);
    });
    $coincidencias = 0;
    foreach ($palabras as $palabra) {
        if (strpos(' ' . $titulo_normalizado . ' ', ' ' . $palabra . ' ') !== false) {
            $coincidencias++;
        }
    }
    if ($busqueda_normalizada !== $titulo_normalizado && $coincidencias < 1) {
        return false;
    }

    $texto = eleam_santoral_normalizar($titulo . ' ' . $extracto);
    // Excluir artículos sobre nombres, incluso cuando mencionen casualmente un santo.
    if (preg_match('/\b(desambiguacion|nombre propio|nombre femenino|nombre masculino|puede referirse)\b/u', $texto)) {
        return false;
    }
    $contexto_religioso = preg_match(
        '/\b(?:santo|santa|santos|santas|catolic[a-z]*|cristian[a-z]*|iglesia|religios[a-z]*|virgen|maria|jesus|apostol|martir|beat[a-z]*|canonizad[a-z]*|obispo|monje|monja|sacerdote|jesuita|advocacion|liturgia|festividad|biblic[a-z]*|evangelio|jesucristo|conmemoracion|beata|franciscana|carmelita)\b/u',
        $texto
    );
    if ($requiere_contexto && !$contexto_religioso) {
        return false;
    }
    $imagen = '';
    if (!empty($pagina['thumbnail']['source'])) {
        $candidata = (string) $pagina['thumbnail']['source'];
        $host = wp_parse_url($candidata, PHP_URL_HOST);
        if (is_string($host) && (strtolower($host) === 'upload.wikimedia.org' || strtolower($host) === 'commons.wikimedia.org')) {
            $imagen = $candidata;
        }
    }
    $enlace = !empty($pagina['fullurl']) ? (string) $pagina['fullurl'] : '';
    $host_articulo = $enlace ? wp_parse_url($enlace, PHP_URL_HOST) : '';
    if ($host_articulo !== 'es.wikipedia.org') {
        $enlace = 'https://es.wikipedia.org/wiki/' . rawurlencode(str_replace(' ', '_', $titulo));
    }
    $archivo = !empty($pagina['pageimage']) ? (string) $pagina['pageimage'] : '';
    $credito = $archivo ? 'https://es.wikipedia.org/wiki/Archivo:' . rawurlencode(str_replace(' ', '_', $archivo)) : '';
    return array(
        'titulo_articulo' => $titulo,
        'descripcion' => wp_trim_words($extracto, 52, '…'),
        'imagen' => $imagen,
        'fuente' => $enlace,
        'credito_imagen' => $credito,
    );
}

/** Wikipedia: primero título explícito, después búsqueda contextual. */
function eleam_santoral_buscar_wikipedia($nombre) {
    $clave = 'eleam_santo_v2_' . md5($nombre);
    $cache = get_transient($clave);
    if ($cache !== false && is_array($cache)) {
        return $cache;
    }

    $titulo = eleam_santoral_titulo_busqueda($nombre);
    $comunes = array(
        'prop' => 'extracts|pageimages|info',
        'exintro' => '1', 'explaintext' => '1', 'exsentences' => 3,
        'piprop' => 'thumbnail|name', 'pithumbsize' => 800,
        'inprop' => 'url', 'redirects' => '1',
    );
    $resultado = array();
    $directo = eleam_santoral_consultar_api(array_merge($comunes, array('titles' => $titulo)));
    if (!empty($directo['query']['pages']) && is_array($directo['query']['pages'])) {
        foreach ($directo['query']['pages'] as $pagina) {
            $candidata = eleam_santoral_evaluar_pagina($pagina, $titulo);
            if ($candidata !== false) {
                $resultado = $candidata;
                break;
            }
        }
    }
    if (!$resultado) {
        // La búsqueda es contextual; no aceptamos homónimos sin contexto religioso.
        $busqueda = eleam_santoral_consultar_api(array_merge($comunes, array(
            'generator' => 'search',
            'gsrsearch' => '"' . $titulo . '" santo católico',
            'gsrnamespace' => 0,
            'gsrlimit' => 5,
        )));
        if (!empty($busqueda['query']['pages']) && is_array($busqueda['query']['pages'])) {
            $paginas = $busqueda['query']['pages'];
            usort($paginas, static function ($a, $b) {
                return (int) ($a['index'] ?? 999) <=> (int) ($b['index'] ?? 999);
            });
            foreach ($paginas as $pagina) {
                $candidata = eleam_santoral_evaluar_pagina($pagina, $titulo);
                if ($candidata !== false) {
                    $resultado = $candidata;
                    break;
                }
            }
        }
    }
    // Los negativos se reintentan al día siguiente; los artículos verificados, mensualmente.
    set_transient($clave, $resultado, $resultado ? 30 * DAY_IN_SECONDS : DAY_IN_SECONDS);
    return $resultado;
}

/** Lee únicamente fechas chilenas contrastadas en el calendario propio local. */
function eleam_santoral_consultar_chile($fecha) {
    $ruta = get_template_directory() . '/assets/data/santoral-chile.json';
    if (!is_readable($ruta)) {
        return array();
    }
    $datos = json_decode((string) file_get_contents($ruta), true);
    $clave = $fecha->format('m-d');
    if (!is_array($datos) || empty($datos[$clave]) || !is_array($datos[$clave])) {
        return array();
    }
    $resultado = array();
    foreach ($datos[$clave] as $entrada) {
        if (!is_array($entrada) || empty($entrada['nombre'])) {
            continue;
        }
        $resultado[] = array(
            'nombre' => sanitize_text_field($entrada['nombre']),
            'titulo_wikipedia' => !empty($entrada['titulo_wikipedia']) ? sanitize_text_field($entrada['titulo_wikipedia']) : '',
            'fuente_calendario' => !empty($entrada['fuente']) ? esc_url_raw($entrada['fuente']) : '',
            'etiqueta_calendario' => 'Calendario litúrgico de Chile',
        );
    }
    return $resultado;
}

/**
 * Extrae títulos de santos de la página del día, sin copiar reseñas externas.
 * El proveedor publica HTML, no una API JSON estable: si cambia su estructura
 * devolvemos [] y se activa el respaldo local.
 */
function eleam_santoral_extraer_vatican($html) {
    if (!is_string($html) || strlen($html) > 600000 || strlen($html) < 100) {
        return array();
    }
    $titulos = array();
    if (class_exists('DOMDocument') && class_exists('DOMXPath')) {
        $anterior = libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $cargado = $dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
        libxml_clear_errors();
        libxml_use_internal_errors($anterior);
        if ($cargado) {
            $xpath = new DOMXPath($dom);
            foreach ($xpath->query('//h2') as $nodo) {
                $titulos[] = trim($nodo->textContent);
            }
        }
    }
    // Respaldo para hostings sin la extensión PHP DOM.
    if (!$titulos && preg_match_all('~<h2\b[^>]*>(.*?)</h2>~si', $html, $coincidencias)) {
        foreach ($coincidencias[1] as $etiqueta) {
            $titulos[] = trim(html_entity_decode(wp_strip_all_tags($etiqueta), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        }
    }
    $santos = array();
    $vistos = array();
    foreach ($titulos as $titulo) {
        // Solo encabezados con fórmula de santoral, no los bloques de navegación.
        $titulo = trim(preg_replace('/\s+/u', ' ', $titulo));
        if (!preg_match('/^(?:s\.\s*|san\s|santa?\s|santos?\s|santas?\s|beato\s|beata\s|nuestra\s+señora\s)/iu', $titulo)) {
            continue;
        }
        $nombre = preg_replace('/^s\.\s*/iu', 'San ', $titulo);
        // Vatican News agrega el oficio tras la coma; no forma parte del nombre.
        $nombre = trim(preg_replace('/,.*$/u', '', $nombre));
        $nombre = sanitize_text_field($nombre);
        if (strlen($nombre) < 7 || strlen($nombre) > 115) {
            continue;
        }
        $clave = eleam_santoral_normalizar($nombre);
        if (isset($vistos[$clave])) {
            continue;
        }
        $vistos[$clave] = true;
        $santos[] = array('nombre' => $nombre);
        if (count($santos) >= 5) {
            break;
        }
    }
    return $santos;
}

/** Lista internacional diaria; endpoint de fecha cerrada (mes/día), con caché. */
function eleam_santoral_consultar_internacional($fecha) {
    $clave = 'eleam_santoral_vaticano_v1_' . $fecha->format('md');
    $cache = get_transient($clave);
    if (is_array($cache)) {
        return $cache;
    }
    $url = 'https://www.vaticannews.va/es/santos/' . $fecha->format('m/d') . '.html';
    $respuesta = wp_remote_get($url, array(
        'timeout' => 5,
        'redirection' => 2,
        'limit_response_size' => 600000,
        'headers' => array('Accept' => 'text/html'),
        'user-agent' => 'ELEAM San Francisco (santoral; ' . home_url('/') . ')',
    ));
    $santos = array();
    if (!is_wp_error($respuesta) && (int) wp_remote_retrieve_response_code($respuesta) === 200) {
        $santos = eleam_santoral_extraer_vatican(wp_remote_retrieve_body($respuesta));
        foreach ($santos as &$santo) {
            $santo['fuente_calendario'] = $url;
            $santo['etiqueta_calendario'] = 'Santoral de Vatican News';
        }
        unset($santo);
    }
    set_transient($clave, $santos, $santos ? DAY_IN_SECONDS : HOUR_IN_SECONDS);
    return $santos;
}

/** Conserva exactamente el respaldo JSON del tema anterior. */
function eleam_santoral_consultar_local($fecha, $meses) {
    $ruta = get_template_directory() . '/assets/data/santorales-catolicos.json';
    if (!is_readable($ruta)) {
        return array();
    }
    $calendario = json_decode((string) file_get_contents($ruta), true);
    $mes = (int) $fecha->format('n');
    $dia = (int) $fecha->format('j');
    if (!is_array($calendario) || empty($calendario[$meses[$mes]]) || !is_array($calendario[$meses[$mes]])) {
        return array();
    }
    $valor = isset($calendario[$meses[$mes]][$dia - 1])
        ? (string) $calendario[$meses[$mes]][$dia - 1] : '';
    $santos = array();
    foreach (eleam_santoral_separar_nombres($valor) as $nombre) {
        $santos[] = array('nombre' => $nombre);
    }
    return $santos;
}

/**
 * Chile > Vaticano > JSON original. La falta de artículo en Wikipedia nunca
 * modifica la selección del santo. Permite fecha ISO opcional para pruebas.
 */
function eleam_santoral_obtener_dia($fecha_iso = '') {
    $zona = new DateTimeZone('America/Santiago');
    $fecha = new DateTimeImmutable('now', $zona);
    if (is_string($fecha_iso) && preg_match('/^\d{4}-\d{2}-\d{2}$/D', $fecha_iso)) {
        $prueba = DateTimeImmutable::createFromFormat('!Y-m-d', $fecha_iso, $zona);
        if ($prueba && $prueba->format('Y-m-d') === $fecha_iso) {
            $fecha = $prueba;
        }
    }
    $meses = array(
        1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
        5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
        9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre',
    );
    $santos = eleam_santoral_consultar_chile($fecha);
    if (!$santos) {
        $santos = eleam_santoral_consultar_internacional($fecha);
    }
    if (!$santos) {
        $santos = eleam_santoral_consultar_local($fecha, $meses);
    }
    foreach ($santos as &$santo) {
        $titulo = !empty($santo['titulo_wikipedia']) ? $santo['titulo_wikipedia'] : $santo['nombre'];
        $wikipedia = eleam_santoral_buscar_wikipedia($titulo);
        if ($wikipedia) {
            // La ficha Wikipedia solo complementa, no decide qué santo se muestra.
            $santo = array_merge($santo, $wikipedia);
            $santo['fuente_etiqueta'] = 'Leer en Wikipedia';
        } else {
            $santo['imagen'] = '';
            $santo['descripcion'] = 'Hoy se conmemora a ' . $santo['nombre'] . '. Consulta la fuente del calendario para conocer más.';
            $santo['fuente'] = !empty($santo['fuente_calendario']) ? $santo['fuente_calendario'] : '';
            $santo['fuente_etiqueta'] = !empty($santo['etiqueta_calendario']) ? 'Consultar ' . $santo['etiqueta_calendario'] : '';
            $santo['credito_imagen'] = '';
        }
    }
    unset($santo);
    return array(
        'fecha_iso' => $fecha->format('Y-m-d'),
        'fecha_legible' => (int) $fecha->format('j') . ' de ' . $meses[(int) $fecha->format('n')],
        'santos' => $santos,
    );
}
