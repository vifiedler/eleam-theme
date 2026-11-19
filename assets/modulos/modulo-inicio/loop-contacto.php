<?php
/** Inicio reutiliza la información SCF de Contacto y su formulario de Contact Form 7. */
defined('ABSPATH') || exit;

$contacto_id = eleam_inicio_contacto_id();
$titulo = eleam_inicio_texto('titulo_contacto_info', $contacto_id, 'Estamos para orientarte');
$descripcion = eleam_inicio_texto('descripcion_contacto_info', $contacto_id);
$titulo_ubicacion = eleam_inicio_texto('titulo_ubicacion', $contacto_id, 'Dónde encontrarnos');
$mapa = eleam_inicio_texto('url_mapa_incrustado', $contacto_id);
$ruta = eleam_inicio_texto('url_como_llegar', $contacto_id);
$titulo_consultas = eleam_inicio_texto('titulo_consultas', $contacto_id, 'Consultas y visitas');
$texto_consultas = eleam_inicio_texto('descripcion_consultas', $contacto_id);
$titulo_formulario = eleam_inicio_texto('titulo_formulario_contacto', $contacto_id, 'Formulario de contacto');
$formulario = eleam_inicio_formulario_cf7();
?>
<section class="seccion seccion-crema" aria-labelledby="titulo-contacto-inicio">
    <div class="contenedor-contenido">
        <div class="row align-items-stretch">
            <div class="col-lg">
                <div class="bloque-contacto-informacion">
                    <h2 id="titulo-contacto-inicio" class="inicio-contacto-titulo"><?php echo esc_html($titulo); ?></h2>
                    <?php if ($descripcion !== ''): ?><p><?php echo esc_html($descripcion); ?></p><?php endif; ?>
                    <h3 class="inicio-contacto-subtitulo"><?php echo esc_html($titulo_ubicacion); ?></h3>
                    <address>Los Libertadores 234, El Monte, Región Metropolitana.</address>
                    <?php if ($mapa !== ''): ?>
                        <iframe class="mapa-referencial inicio-mapa" src="<?php echo esc_url($mapa); ?>"
                            title="Ubicación del ELEAM San Francisco en El Monte" width="524" height="240"
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                    <?php endif; ?>
                    <?php if ($ruta !== ''): ?>
                        <p class="inicio-como-llegar"><a href="<?php echo esc_url($ruta); ?>" target="_blank" rel="noopener noreferrer">Cómo llegar <span class="bi bi-box-arrow-up-right" aria-hidden="true"></span></a></p>
                    <?php endif; ?>
                    <h3 class="inicio-contacto-subtitulo"><?php echo esc_html($titulo_consultas); ?></h3>
                    <?php if ($texto_consultas !== ''): ?><p><?php echo esc_html($texto_consultas); ?></p><?php endif; ?>
                </div>
            </div>
            <div class="col-lg-auto d-none d-lg-block"><div class="vr h-100"></div></div>
            <div class="col-lg">
                <div class="formulario-contacto">
                    <h2 class="inicio-formulario-titulo"><?php echo esc_html($titulo_formulario); ?></h2>
                    <?php if ($formulario !== ''): ?>
                        <?php echo $formulario; // HTML producido y saneado por Contact Form 7. ?>
                    <?php else: ?>
                        <p>El formulario de contacto no está disponible en este momento.</p>
                        <?php if ($contacto_id): ?><a href="<?php echo esc_url(get_permalink($contacto_id)); ?>">Ir a Contacto</a><?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
