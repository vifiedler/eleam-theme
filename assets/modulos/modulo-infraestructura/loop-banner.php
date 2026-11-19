<?php
/** Banner de contribución propio de Infraestructura. */
defined('ABSPATH') || exit;
$titulo = eleam_inicio_texto('titulo_banner');
$texto = eleam_inicio_texto('texto_banner');
$boton = eleam_inicio_enlace('enlace_donacion', '/contribuye/', 'Contribuye');
if ($titulo === '' && $texto === '') {
    return;
}
?>
<section class="banner-contribucion" aria-labelledby="titulo-contribucion-infraestructura">
    <div class="contenedor-contenido">
        <?php if ($titulo !== ''): ?><h2 id="titulo-contribucion-infraestructura"><?php echo esc_html($titulo); ?></h2><?php endif; ?>
        <?php if ($texto !== ''): ?><p><?php echo esc_html($texto); ?></p><?php endif; ?>
        <?php eleam_inicio_boton($boton, 'boton-primario'); ?>
    </div>
</section>
