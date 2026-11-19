<?php
/** Nuestro compromiso: tarjetas editables de Inicio. */
defined('ABSPATH') || exit;
$filas = eleam_inicio_campo('tarjetas_compromiso_inicio', false, array());
$tarjetas = is_array($filas) ? $filas : array();
?>
<section class="seccion seccion-crema" aria-labelledby="titulo-compromiso">
    <div class="container">
        <header class="encabezado-seccion">
            <h2 id="titulo-compromiso"><?php echo esc_html(eleam_inicio_texto('titulo_compromiso_inicio', false, 'Nuestro compromiso')); ?></h2>
        </header>
        
        <!-- row-cols-lg-3 hace que se muestren 3 por fila en escritorio -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($tarjetas as $tarjeta):
                $titulo = isset($tarjeta['titulo_tarjeta_compromiso_inicio']) ? (string) $tarjeta['titulo_tarjeta_compromiso_inicio'] : '';
                $texto = isset($tarjeta['texto_compromiso_inicio']) ? (string) $tarjeta['texto_compromiso_inicio'] : '';
                $imagen = eleam_inicio_imagen(isset($tarjeta['imagen_compromiso_inicio']) ? $tarjeta['imagen_compromiso_inicio'] : null, 'compromiso-imagen', '', 'medium_large');
                if ($titulo === '' && $texto === '' && $imagen === '') { continue; }
                ?>
                <div class="col">
                    <article class="compromiso-tarjeta">
                        <?php if ($imagen !== ''): ?><?php echo $imagen; // HTML seguro. ?><?php endif; ?>
                        <div class="compromiso-contenido">
                            <?php if ($titulo !== ''): ?><h3 class="compromiso-titulo"><?php echo esc_html($titulo); ?></h3><?php endif; ?>
                            <?php if ($texto !== ''): ?><p class="compromiso-texto"><?php echo esc_html($texto); ?></p><?php endif; ?>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
        
    </div>
</section>