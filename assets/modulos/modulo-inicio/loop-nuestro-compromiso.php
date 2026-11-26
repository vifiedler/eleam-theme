<?php
/** Nuestro compromiso: tarjetas editables de Inicio. */
defined('ABSPATH') || exit;
$filas = eleam_inicio_campo('tarjetas_compromiso_inicio', false, array());
$tarjetas = is_array($filas) ? $filas : array();

// Agrupamos: las primeras 3 en una fila, el resto en otra fila de 2
$grupos = array(
    array('clase' => 'row row-cols-1 row-cols-md-3 g-4', 'items' => array_slice($tarjetas, 0, 3)),
    array('clase' => 'row row-cols-1 row-cols-md-2 g-4 mt-2', 'items' => array_slice($tarjetas, 3)),
);
?>
<section class="seccion seccion-crema" aria-labelledby="titulo-compromiso">
    <div class="container">
        <header class="encabezado-seccion">
            <h2 id="titulo-compromiso"><?php echo esc_html(eleam_inicio_texto('titulo_compromiso_inicio', false, 'Nuestro compromiso')); ?></h2>
        </header>
        
        <?php foreach ($grupos as $grupo): ?>
            <?php if (!$grupo['items']) { continue; } ?>
            <div class="<?php echo esc_attr($grupo['clase']); ?>">
                <?php foreach ($grupo['items'] as $tarjeta):
                    $titulo = isset($tarjeta['titulo_tarjeta_compromiso_inicio']) ? (string) $tarjeta['titulo_tarjeta_compromiso_inicio'] : '';
                    $texto = isset($tarjeta['texto_compromiso_inicio']) ? (string) $tarjeta['texto_compromiso_inicio'] : '';
                    $imagen = eleam_inicio_imagen(isset($tarjeta['imagen_compromiso_inicio']) ? $tarjeta['imagen_compromiso_inicio'] : null, 'compromiso-imagen', '', 'medium_large');
                    if ($titulo === '' && $texto === '' && $imagen === '') { continue; }
                    ?>
                    <div class="col">
                        <article class="compromiso-tarjeta">
                            <?php if ($imagen !== ''): ?><?php echo $imagen; ?><?php endif; ?>
                            <div class="compromiso-contenido">
                                <?php if ($titulo !== ''): ?><h3 class="compromiso-titulo"><?php echo esc_html($titulo); ?></h3><?php endif; ?>
                                <?php if ($texto !== ''): ?><p class="compromiso-texto"><?php echo esc_html($texto); ?></p><?php endif; ?>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>