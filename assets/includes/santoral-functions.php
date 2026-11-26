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

/**
 * Calendario propio de Chile. Archivo de datos del tema, no de WordPress.
 * Sólo incluye celebraciones de fecha fija. Las móviles requieren Ordo anual.
 */
function eleam_santoral_obtener_chile($mes, $dia) {
    $ruta = get_template_directory() . '/assets/data/santoral-chile.json';
    if (!is_readable($ruta)) {
        return array();
    }

    $datos = json_decode((string) file_get_contents($ruta), true);
    if (!is_array($datos)) {
        return array();
    }

    $clave = sprintf('%02d-%02d', (int) $mes, (int) $dia);
    $seleccion = isset($datos[$clave]) ? $datos[$clave] : array();
    return is_array($seleccion) ? array_values(array_filter($seleccion, static function ($item) {
        return is_array($item) && !empty($item['nombre']) && is_string($item['nombre']);
    })) : array();
}

/**
 * Extrae sólo los nombres de santos publicados por Vatican News.
 * No reutiliza ni copia sus reseñas; las biografías siguen viniendo de Wikipedia.
 * Un cambio de HTML o un bloqueo HTTP activa el JSON local de respaldo.
 */
function eleam_santoral_extraer_vatican_html($html) {
    if (!is_string($html) || $html === '') {
        return array();
    }

    $encabezados = array();
    if (class_exists('DOMDocument')) {
        $documento = new DOMDocument();
        $estado_anterior = libxml_use_internal_errors(true);
        $procesado = $documento->loadHTML('<?xml encoding="utf-8"?>' . $html);
        libxml_clear_errors();
        libxml_use_internal_errors($estado_anterior);
        if ($procesado) {
            $xpath = new DOMXPath($documento);
            $nodos = $xpath->query('//h1 | //h2 | //h3 | //h4');
            if ($nodos) {
                foreach ($nodos as $nodo) {
                    $encabezados[] = (string) $nodo->textContent;
                }
            }
        }
    } elseif (preg_match_all('~<h[1-4]\b[^>]*>(.*?)</h[1-4]>~isu', $html, $encontrados)) {
        // Respaldo cuando la extensión PHP DOM no está habilitada en el hosting.
        foreach ($encontrados[1] as $encabezado) {
            $encabezados[] = html_entity_decode(strip_tags($encabezado), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }
    }

    $en_santoral = false;
    $santos = array();
    $vistos = array();
    foreach ($encabezados as $encabezado) {
        $titulo = trim(preg_replace('/\s+/u', ' ', $encabezado));
        if (preg_match('/^santos? del d[ií]a$/iu', $titulo)) {
            $en_santoral = true;
            continue;
        }
        if (!$en_santoral) {
            continue;
        }
        if (preg_match('/^(actividad del papa|nuestra fe|informaciones [uú]tiles|nuestros canales)$/iu', $titulo)) {
            break;
        }
        if (!preg_match('/^(?:s\.|san(?:to|ta)?\b|beato\b|beata\b|santos\b|santas\b|virgen\b|nuestra se[ñn]ora\b)\s*/iu', $titulo)) {
            continue;
        }

        // Retirar calificativos descriptivos, sin truncar advocaciones marianas.
        $nombre = preg_replace('/,\s*(?:papa|sacerdote|presb[ií]tero|franciscano|abad|abadesa|m[aá]rtir|religios[oa]|fundador[ae]?|virgen|obispo|di[aá]cono|ap[oó]stol|ermita[ñn]o)\b.*$/iu', '', $titulo);
        $nombre = trim((string) $nombre);
        $busqueda = trim((string) preg_replace('/^(?:s\.|san|santa|santo|beato|beata)\s+/iu', '', $nombre));
        if ($busqueda === '') {
            $busqueda = $nombre;
        }
        $clave = eleam_santoral_normalizar($nombre);
        if ($clave !== '' && !isset($vistos[$clave])) {
            $vistos[$clave] = true;
            $santos[] = array('nombre' => $nombre, 'busqueda' => $busqueda);
        }
        if (count($santos) >= 8) {
            break;
        }
    }
    return $santos;
}

/** Santoral internacional con caché; no requiere plugins ni endpoints propios. */
function eleam_santoral_obtener_internacional($mes, $dia) {
    $clave = sprintf('eleam_vatican_v1_%02d_%02d', (int) $mes, (int) $dia);
    $guardado = get_transient($clave);
    if (is_array($guardado)) {
        return $guardado;
    }

    $url = sprintf('https://www.vaticannews.va/es/santos/%02d/%02d.html', (int) $mes, (int) $dia);
    $respuesta = wp_safe_remote_get($url, array(
        'timeout' => 5,
        'redirection' => 2,
        'user-agent' => 'ELEAM-Santoral/1.1 (' . home_url('/') . '; WordPress)',
        'headers' => array('Accept' => 'text/html'),
        'limit_response_size' => 350000,
    ));

    $santos = array();
    if (!is_wp_error($respuesta) && (int) wp_remote_retrieve_response_code($respuesta) === 200) {
        $santos = eleam_santoral_extraer_vatican_html(wp_remote_retrieve_body($respuesta));
    }
    set_transient($clave, $santos, $santos ? DAY_IN_SECONDS : HOUR_IN_SECONDS);
    return $santos;
}

/** Respaldo original del tema, sólo cuando no hay datos de las otras fuentes. */
function eleam_santoral_obtener_local($mes, $dia, $nombre_mes) {
    $ruta = get_template_directory() . '/assets/data/santorales-catolicos.json';
    if (!is_readable($ruta)) {
        return array();
    }
    $calendario = json_decode((string) file_get_contents($ruta), true);
    $entradas = is_array($calendario) && !empty($calendario[$nombre_mes]) && is_array($calendario[$nombre_mes])
        ? $calendario[$nombre_mes] : array();
    $valor = isset($entradas[$dia - 1]) ? (string) $entradas[$dia - 1] : '';
    $resultado = array();
    foreach (eleam_santoral_separar_nombres($valor) as $nombre) {
        $resultado[] = array('nombre' => $nombre, 'busqueda' => $nombre);
    }
    return $resultado;
}

/**
 * Prioridad de selección: propio de Chile → Vaticano → JSON local.
 * La falta de biografía NO cambia de santo: sólo afecta el enriquecimiento.
 */
function eleam_santoral_obtener_dia($fecha = null) {
    $zona = new DateTimeZone('America/Santiago');
    if (!($fecha instanceof DateTimeInterface)) {
        $fecha = new DateTimeImmutable('now', $zona);
    }
    $fecha = new DateTimeImmutable($fecha->format('Y-m-d'), $zona);

    $meses = array(
        1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
        5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
        9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre',
    );
    $mes = (int) $fecha->format('n');
    $dia = (int) $fecha->format('j');

    $seleccion = eleam_santoral_obtener_chile($mes, $dia);
    $origen = 'Iglesia.cl';
    $enlace_origen = 'https://www.iglesia.cl/docs/Ordo_Pastoral_2022_Final.pdf';
    if (!$seleccion) {
        $seleccion = eleam_santoral_obtener_internacional($mes, $dia);
        $origen = 'Vatican News';
        $enlace_origen = sprintf('https://www.vaticannews.va/es/santos/%02d/%02d.html', $mes, $dia);
    }
    if (!$seleccion) {
        $seleccion = eleam_santoral_obtener_local($mes, $dia, $meses[$mes]);
        $origen = '';
        $enlace_origen = '';
    }

    $santos = array();
    foreach ($seleccion as $item) {
        $nombre = trim((string) $item['nombre']);
        $busqueda = !empty($item['busqueda']) ? (string) $item['busqueda'] : $nombre;
        $detalle = eleam_santoral_buscar_wikipedia($busqueda);
        $santo = array_merge(array(
            'nombre' => $nombre,
            'fuente' => $enlace_origen,
            'fuente_tipo' => $origen,
        ), $detalle);
        if (!empty($detalle['fuente'])) {
            $santo['fuente_tipo'] = 'Wikipedia';
        }
        $santos[] = $santo;
    }

    return array(
        'fecha_iso' => $fecha->format('Y-m-d'),
        'fecha_legible' => $dia . ' de ' . $meses[$mes],
        'santos' => $santos,
    );
}
