<?php
/** Presentación del santoral; Wikipedia se consulta sólo desde santoral-functions.php. */
defined('ABSPATH') || exit;

$datos = eleam_santoral_obtener_dia();
$santos = $datos['santos'];
$total = count($santos);
$etiqueta_scf = function_exists('get_field') ? (string) get_field('etiqueta_santo_del_dia') : '';
$etiqueta = trim($etiqueta_scf) !== '' ? $etiqueta_scf : 'Santos del día';
$texto_respaldo = function_exists('get_field') ? (string) get_field('texto_santo_no_disponible') : '';
$texto_respaldo = trim($texto_respaldo) !== '' ? $texto_respaldo : 'No hay una reseña disponible en Wikipedia para esta conmemoración.';
$imagen_respaldo = function_exists('get_field') ? get_field('imagen_santo_no_disponible') : null;
$url_respaldo = '';
if (is_array($imagen_respaldo) && !empty($imagen_respaldo['url'])) {
    $url_respaldo = (string) $imagen_respaldo['url'];
} elseif (is_numeric($imagen_respaldo)) {
    $url_respaldo = (string) wp_get_attachment_image_url((int) $imagen_respaldo, 'large');
} elseif (is_string($imagen_respaldo) && wp_http_validate_url($imagen_respaldo)) {
    $url_respaldo = $imagen_respaldo;
}
if (!$total) {
    $santos = array(array('nombre' => 'Santoral no disponible'));
    $total = 1;
}
?>
<div class="santoral" data-santoral <?php if ($total > 1): ?>role="region" aria-roledescription="carrusel" aria-label="Santos del día"<?php endif; ?>>
    <div class="santoral-diapositivas" aria-live="off">
        <?php foreach ($santos as $indice => $santo):
            $imagen_verificada = !empty($santo['imagen']);
            $imagen = $imagen_verificada ? $santo['imagen'] : $url_respaldo;
            $alt_imagen = $imagen_verificada ? 'Imagen relacionada con ' . $santo['nombre'] : 'Imagen ilustrativa de respaldo del santoral';
            $descripcion = !empty($santo['descripcion']) ? $santo['descripcion'] : $texto_respaldo;
            $id_nombre = 'nombre-santoral-' . $indice;
        ?>
            <article class="card tarjeta tarjeta-santo-dia santoral-diapositiva"
                     data-santoral-diapositiva
                     aria-labelledby="<?php echo esc_attr($id_nombre); ?>"
                     <?php if ($total > 1): ?>aria-roledescription="diapositiva"<?php endif; ?>
                     <?php if ($indice > 0): ?>hidden<?php endif; ?>>
                <header class="santo-dia-cabecera">
                    <p class="santo-dia-etiqueta"><?php echo esc_html($etiqueta); ?></p>
                    <h3 class="santo-dia-nombre" id="<?php echo esc_attr($id_nombre); ?>"><?php echo esc_html($santo['nombre']); ?></h3>
                </header>
                <figure class="santo-dia-imagen">
                    <?php if ($imagen): ?>
                        <img src="<?php echo esc_url($imagen); ?>" alt="<?php echo esc_attr($alt_imagen); ?>" loading="lazy" decoding="async" width="800" height="500">
                    <?php else: ?>
                        <div class="santoral-sin-imagen" role="img" aria-label="Imagen no disponible">
                            <span class="bi bi-person-circle" aria-hidden="true"></span>
                        </div>
                    <?php endif; ?>
                </figure>
                <div class="santo-dia-contenido">
                    <p class="santo-dia-fecha">
                        <span class="bi bi-calendar3" aria-hidden="true"></span>
                        <time datetime="<?php echo esc_attr($datos['fecha_iso']); ?>"><?php echo esc_html($datos['fecha_legible']); ?></time>
                    </p>
                    <p class="santo-dia-descripcion"><?php echo esc_html($descripcion); ?></p>
                    <?php if (!empty($santo['fuente'])): ?>
                        <p class="santoral-fuente"><a href="<?php echo esc_url($santo['fuente']); ?>" target="_blank" rel="noopener noreferrer">Leer en <?php echo esc_html(!empty($santo['fuente_tipo']) ? $santo['fuente_tipo'] : 'Wikipedia'); ?> <span class="bi bi-box-arrow-up-right" aria-hidden="true"></span></a></p>
                    <?php endif; ?>
                    <?php if (!empty($santo['imagen']) && !empty($santo['credito_imagen'])): ?>
                        <p class="santoral-fuente santoral-credito"><a href="<?php echo esc_url($santo['credito_imagen']); ?>" target="_blank" rel="noopener noreferrer">Fuente y licencia de la imagen</a></p>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
    <?php if ($total > 1): ?>
        <div class="santoral-controles" role="group" aria-label="Controles del santoral">
            <button class="santoral-control" type="button" data-santoral-anterior aria-label="Santo anterior">
                <span class="bi bi-arrow-left" aria-hidden="true"></span>
            </button>
            <span class="santoral-posicion" data-santoral-posicion role="status" aria-live="polite" aria-atomic="true">1 de <?php echo esc_html((string) $total); ?></span>
            <button class="santoral-control" type="button" data-santoral-siguiente aria-label="Santo siguiente">
                <span class="bi bi-arrow-right" aria-hidden="true"></span>
            </button>
        </div>
    <?php endif; ?>
</div>
