<?php
/**
 * Santoral de Inicio: lectura del calendario local y consulta pública de Wikipedia.
 * No modifica el JSON original ni necesita registros o campos SCF adicionales.
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

/** Devuelve los santos de la fecha actual en Chile y sus datos complementarios. */
function eleam_santoral_obtener_dia() {
    $fecha = new DateTimeImmutable('now', new DateTimeZone('America/Santiago'));
    $meses = array(
        1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
        5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
        9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre',
    );
    $mes = (int) $fecha->format('n');
    $dia = (int) $fecha->format('j');
    $ruta = get_template_directory() . '/assets/data/santorales-catolicos.json';
    $calendario = array();
    if (is_readable($ruta)) {
        $contenido = file_get_contents($ruta); // Ruta fija y local, sólo lectura.
        $decodificado = json_decode($contenido, true);
        if (is_array($decodificado)) {
            $calendario = $decodificado;
        }
    }
    $entradas = isset($calendario[$meses[$mes]]) && is_array($calendario[$meses[$mes]])
        ? $calendario[$meses[$mes]] : array();
    $valor = isset($entradas[$dia - 1]) ? (string) $entradas[$dia - 1] : '';
    $nombres = eleam_santoral_separar_nombres($valor);
    $santos = array();
    foreach ($nombres as $nombre) {
        $santos[] = array_merge(
            array('nombre' => $nombre),
            eleam_santoral_buscar_wikipedia($nombre)
        );
    }
    return array(
        'fecha_iso' => $fecha->format('Y-m-d'),
        'fecha_legible' => $dia . ' de ' . $meses[$mes],
        'santos' => $santos,
    );
}
