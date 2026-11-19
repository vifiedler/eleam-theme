<?php
/** Funciones específicas para los loops de Transparencia. */
defined('ABSPATH') || exit;

/** Campos SCF. No declarar falsos reemplazos globales para get_field(). */
function eleam_transparencia_campo($nombre, $post_id = false, $defecto = '') {
    if (!function_exists('get_field')) {
        return $defecto;
    }
    $valor = $post_id ? get_field($nombre, $post_id) : get_field($nombre);
    return ($valor === null || $valor === false || $valor === '') ? $defecto : $valor;
}

function eleam_transparencia_texto($nombre, $post_id = false, $defecto = '') {
    $valor = eleam_transparencia_campo($nombre, $post_id, $defecto);
    return is_scalar($valor) ? trim((string) $valor) : $defecto;
}

function eleam_transparencia_filas($nombre, $post_id = false) {
    $filas = eleam_transparencia_campo($nombre, $post_id, array());
    return is_array($filas) ? array_values(array_filter($filas, 'is_array')) : array();
}

/** Imágenes de SCF: ID de adjunto, array o URL, usando el helper ya cargado en el tema. */
function eleam_transparencia_imagen($imagen, $clases = 'tarjeta-imagen', $alt = '', $tamano = 'medium_large', $carga = 'lazy') {
    if (!function_exists('eleam_inicio_imagen')) {
        return '';
    }
    return eleam_inicio_imagen($imagen, $clases, $alt, $tamano, $carga);
}

/** URL de un PDF administrado en SCF. Soporta el formato archivo: ID, URL o array. */
function eleam_transparencia_archivo_url($archivo) {
    if (is_array($archivo)) {
        $archivo = !empty($archivo['url']) ? $archivo['url'] : (isset($archivo['ID']) ? $archivo['ID'] : (isset($archivo['id']) ? $archivo['id'] : ''));
    }
    if (is_numeric($archivo) && (int) $archivo > 0) {
        $archivo = wp_get_attachment_url((int) $archivo);
    }
    if (!is_string($archivo) || trim($archivo) === '') {
        return '';
    }
    return esc_url_raw($archivo);
}

/** Fecha SCF, que puede retornar Ymd, Y-m-d o d/m/Y. */
function eleam_transparencia_fecha($valor) {
    if (!is_scalar($valor) || trim((string) $valor) === '') {
        return '';
    }
    $valor = trim((string) $valor);
    foreach (array('Ymd', 'Y-m-d', 'd/m/Y') as $formato) {
        $fecha = DateTimeImmutable::createFromFormat('!' . $formato, $valor);
        if ($fecha instanceof DateTimeImmutable && $fecha->format($formato) === $valor) {
            return $fecha->format('d/m/Y');
        }
    }
    return $valor;
}

/** Monto CLP sin decimales y sin inventar ceros para valores no disponibles. */
function eleam_transparencia_monto($valor) {
    if (!is_scalar($valor) || $valor === '') {
        return '';
    }
    $numero = str_replace(array('.', ' ', '$'), '', (string) $valor);
    return preg_match('/^-?\\d+$/', $numero) ? '$' . number_format((int) $numero, 0, ',', '.') : '';
}

/** Renderiza una tarjeta del directorio de Fundación, con fotografía opcional. */
function eleam_transparencia_tarjeta_directorio($fila, $destacada = false) {
    $nombre = isset($fila['nombre_directorio_fundacion']) ? trim((string) $fila['nombre_directorio_fundacion']) : '';
    $cargo = isset($fila['cargo_directorio_fundacion']) ? trim((string) $fila['cargo_directorio_fundacion']) : '';
    $detalle = isset($fila['detalle_directorio_fundacion']) ? trim((string) $fila['detalle_directorio_fundacion']) : '';
    if ($nombre === '') {
        return;
    }
    $imagen = eleam_transparencia_imagen(isset($fila['foto_directorio_fundacion']) ? $fila['foto_directorio_fundacion'] : null, 'img-fluid card-img-top tarjeta-imagen', 'Retrato de ' . $nombre);
    ?>
    <article class="card tarjeta tarjeta-directorio<?php echo $destacada ? ' tarjeta-directorio-destacada' : ''; ?>">
        <?php if ($imagen !== ''): ?>
            <?php echo $imagen; // HTML generado por wp_get_attachment_image()/helper interno. ?>
        <?php else: ?>
            <div class="transparencia-retrato-vacio" aria-hidden="true"><span class="bi bi-person"></span></div>
        <?php endif; ?>
        <div class="card-body">
            <h3><?php echo esc_html($nombre); ?></h3>
            <?php if ($cargo !== ''): ?><p><?php echo esc_html($cargo); ?></p><?php endif; ?>
            <?php if ($detalle !== ''): ?><small class="texto-secundario"><?php echo esc_html($detalle); ?></small><?php endif; ?>
        </div>
    </article>
    <?php
}

/** Obtener registros públicos para la tabla y su CSV. */
function eleam_transparencia_transferencias($post_id = false) {
    return eleam_transparencia_filas('tabla_transferencias', $post_id);
}

/** Sanitización de celdas CSV para impedir ejecución de fórmulas en hojas de cálculo. */
function eleam_transparencia_csv_seguro($valor) {
    $texto = is_scalar($valor) ? trim((string) $valor) : '';
    if (preg_match('/^[\\s]*[=+@\\-]/u', $texto)) {
        $texto = "'" . $texto;
    }
    return $texto;
}

/** Descarga CSV real desde SCF; no crea ni administra archivos en el servidor. */
function eleam_transparencia_descargar_csv() {
    $id = isset($_GET['pagina']) ? absint(wp_unslash($_GET['pagina'])) : 0;
    $pagina = $id ? get_post($id) : null;
    if (!($pagina instanceof WP_Post) || $pagina->post_type !== 'page' || $pagina->post_status !== 'publish' || get_page_template_slug($id) !== 'page-transparencia.php') {
        wp_die(esc_html__('Registro no disponible.', 'eleam-theme'), '', array('response' => 404));
    }
    $filas = eleam_transparencia_transferencias($id);
    if (!$filas) {
        wp_die(esc_html__('No hay transferencias registradas para descargar.', 'eleam-theme'), '', array('response' => 404));
    }
    nocache_headers();
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="transferencias-eleam.csv"');
    $salida = fopen('php://output', 'w');
    if (!$salida) {
        wp_die(esc_html__('No fue posible generar el CSV.', 'eleam-theme'));
    }
    fwrite($salida, "\xEF\xBB\xBF");
    fputcsv($salida, array('Código Proyecto', 'Programa', 'N.º Transferencia', 'Fecha', 'Monto CLP', 'Período', 'Estado'), ';', '"', '');
    foreach ($filas as $fila) {
        fputcsv($salida, array(
            eleam_transparencia_csv_seguro(isset($fila['codigo_proyecto_transferencia']) ? $fila['codigo_proyecto_transferencia'] : ''),
            eleam_transparencia_csv_seguro(isset($fila['programa_transferencia']) ? $fila['programa_transferencia'] : ''),
            eleam_transparencia_csv_seguro(isset($fila['numero_transferencia']) ? $fila['numero_transferencia'] : ''),
            eleam_transparencia_csv_seguro(eleam_transparencia_fecha(isset($fila['fecha_transferencia']) ? $fila['fecha_transferencia'] : '')),
            eleam_transparencia_csv_seguro(isset($fila['monto_transferencia']) ? $fila['monto_transferencia'] : ''),
            eleam_transparencia_csv_seguro(isset($fila['periodo_transferencia']) ? $fila['periodo_transferencia'] : ''),
            eleam_transparencia_csv_seguro(isset($fila['estado_transferencia']) ? $fila['estado_transferencia'] : ''),
        ), ';', '"', '');
    }
    fclose($salida);
    exit;
}
add_action('admin_post_eleam_transparencia_csv', 'eleam_transparencia_descargar_csv');
add_action('admin_post_nopriv_eleam_transparencia_csv', 'eleam_transparencia_descargar_csv');

/** Estilos locales para estados vacíos y tarjetas de Transparencia. */
function eleam_transparencia_encolar_css() {
    if (!is_page_template('page-transparencia.php')) {
        return;
    }
    $ruta = '/assets/librerias/css/transparencia.css';
    wp_enqueue_style('eleam-transparencia', get_template_directory_uri() . $ruta, array('componentes-css'), file_exists(get_template_directory() . $ruta) ? (string) filemtime(get_template_directory() . $ruta) : null);
}
add_action('wp_enqueue_scripts', 'eleam_transparencia_encolar_css', 30);
