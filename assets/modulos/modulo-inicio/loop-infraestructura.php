<?php
/** Infraestructura de Inicio: tres tarjetas y enlace a la página nativa. */
defined('ABSPATH') || exit;
$filas = eleam_inicio_campo('tarjetas_infraestructura_inicio', false, array());
$tarjetas = is_array($filas) ? $filas : array();
$boton = eleam_inicio_enlace('boton_infraestructura_inicio', '/infraestructura/', 'Ver infraestructura');
?>
<section class="seccion" aria-labelledby="titulo-infraestructura">
    <div class="container">
        <header class="encabezado-seccion">
            <h2 id="titulo-infraestructura"><?php echo esc_html(eleam_inicio_texto('titulo_infraestructura_inicio', false, 'Infraestructura')); ?></h2>
        </header>
        <div class="row justify-content-between g-4">
            <?php foreach ($tarjetas as $tarjeta):
                $titulo = isset($tarjeta['titulo_tarjeta_infra_inicio']) ? (string) $tarjeta['titulo_tarjeta_infra_inicio'] : '';
                $texto = isset($tarjeta['descripcion_tarjeta_infra_inicio']) ? (string) $tarjeta['descripcion_tarjeta_infra_inicio'] : '';
                $imagen = eleam_inicio_imagen(isset($tarjeta['imagen_tarjeta_infra_inicio']) ? $tarjeta['imagen_tarjeta_infra_inicio'] : null, 'img-fluid card-img-top tarjeta-imagen', $titulo, 'medium_large');
                if ($titulo === '' && $texto === '' && $imagen === '') { continue; }
                ?>
                <div class="col-md-4">
                    <article class="card tarjeta">
                        <?php echo $imagen; // HTML seguro. ?>
                        <div class="card-body">
                            <?php if ($titulo !== ''): ?><h3 class="card-title"><?php echo esc_html($titulo); ?></h3><?php endif; ?>
                            <?php if ($texto !== ''): ?><p class="card-text"><?php echo esc_html($texto); ?></p><?php endif; ?>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="acciones-seccion"><?php eleam_inicio_boton($boton); ?></div>
    </div>
</section>
