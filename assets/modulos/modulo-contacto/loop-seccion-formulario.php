<?php
/** Información y formulario exclusivos de la página Contacto. */
defined('ABSPATH') || exit;

$titulo = eleam_interior_texto('titulo_contacto_info', false, 'Estamos para orientarte');
$descripcion = eleam_interior_texto('descripcion_contacto_info');
$titulo_ubicacion = eleam_interior_texto('titulo_ubicacion', false, 'Dónde encontrarnos');
$mapa = eleam_interior_texto('url_mapa_incrustado');
$ruta = eleam_interior_texto('url_como_llegar');
$titulo_consultas = eleam_interior_texto('titulo_consultas', false, 'Consultas y visitas');
$texto_consultas = eleam_interior_texto('descripcion_consultas');
$titulo_formulario = eleam_interior_texto('titulo_formulario_contacto', false, 'Formulario de contacto');
$formulario = eleam_inicio_formulario_cf7();
?>
<section class="seccion seccion-crema" aria-label="Información de contacto y formulario">
    <div class="contenedor-contenido">
        <div class="row align-items-stretch">
            <div class="col-lg">
                <div class="bloque-contacto-informacion">
                    <h2 class="d-none"><?php echo esc_html($titulo_formulario); ?></h2>
                    <h3><?php echo esc_html($titulo); ?></h3>
                    <?php if ($descripcion !== ''): ?><p><?php echo esc_html($descripcion); ?></p><?php endif; ?>
                    <h4><?php echo esc_html($titulo_ubicacion); ?></h4>
                    <address>Los Libertadores 234, El Monte, Región Metropolitana.</address>
                    <?php if ($mapa !== ''): ?>
                        <iframe class="mapa-referencial" src="<?php echo esc_url($mapa); ?>"
                            title="Ubicación del ELEAM San Francisco, Los Libertadores 234, El Monte"
                            width="524" height="240" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                    <?php endif; ?>
                    <?php if ($ruta !== ''): ?>
                        <p class="inicio-como-llegar">
                            <a href="<?php echo esc_url($ruta); ?>" target="_blank" rel="noopener noreferrer">
                                Cómo llegar <span class="bi bi-box-arrow-up-right" aria-hidden="true"></span>
                            </a>
                        </p>
                    <?php endif; ?>
                    <h4><?php echo esc_html($titulo_consultas); ?></h4>
                    <?php if ($texto_consultas !== ''): ?><p><?php echo esc_html($texto_consultas); ?></p><?php endif; ?>
                </div>
            </div>
            <div class="col-lg-auto d-none d-lg-block">
                <div class="vr h-100"></div>
            </div>
            <div class="col-lg">
                <div class="formulario-contacto">
                    <?php if ($formulario !== ''): ?>
                        <?php echo $formulario; // HTML producido y saneado por Contact Form 7. ?>
                    <?php else: ?>
                        <p>El formulario de contacto no está disponible en este momento.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
