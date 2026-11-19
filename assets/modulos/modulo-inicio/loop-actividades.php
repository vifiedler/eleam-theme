<?php
/** Actividades de Inicio: mosaico de fotografías desde el repetidor SCF. */
defined('ABSPATH') || exit;
$filas = eleam_inicio_campo('imagenes_collage_actividades_inicio', false, array());
$piezas = is_array($filas) ? $filas : array();
$boton = eleam_inicio_enlace('boton_actividades_inicio', '/actividades/', 'Ver actividades');
?>
<section class="seccion seccion-crema" aria-labelledby="titulo-momentos">
    <div class="container">
        <header class="encabezado-seccion">
            <h2 id="titulo-momentos"><?php echo esc_html(eleam_inicio_texto('titulo_actividades_inicio', false, 'Actividades')); ?></h2>
        </header>
        <div class="galeria-actividades">
            <div class="galeria-actividades-texto">
                <h3><?php echo esc_html(eleam_inicio_texto('titulo_collage_actividades_inicio', false, 'Momentos que nos unen')); ?></h3>
                <p><?php echo esc_html(eleam_inicio_texto('descripcion_actividades_inicio')); ?></p>
            </div>
            <?php foreach ($piezas as $pieza):
                $rotulo = isset($pieza['rotulo_collage_actividad']) ? (string) $pieza['rotulo_collage_actividad'] : '';
                $descripcion = isset($pieza['descripcion_collage_actividad']) ? (string) $pieza['descripcion_collage_actividad'] : '';
                $imagen = eleam_inicio_imagen(isset($pieza['imagen_collage_actividad']) ? $pieza['imagen_collage_actividad'] : null, 'img-fluid', $rotulo, 'large');
                if ($imagen === '') { continue; }
                ?>
                <figure class="galeria-mosaico-pieza" data-rotulo="<?php echo esc_attr($rotulo); ?>" tabindex="0">
                    <?php echo $imagen; // HTML seguro. ?>
                    <figcaption class="galeria-mosaico-pie"><?php echo esc_html($descripcion !== '' ? $descripcion : $rotulo); ?></figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
        <div class="acciones-seccion"><?php eleam_inicio_boton($boton); ?></div>
    </div>
</section>
