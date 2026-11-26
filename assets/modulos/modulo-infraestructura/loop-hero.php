<?php
/** Encabezado de Infraestructura: todos los contenidos provienen de SCF. */
defined('ABSPATH') || exit;
$titulo = eleam_inicio_texto('titulo_pagina', false, get_the_title());
$bajada = eleam_inicio_texto('bajada_texto');
$imagen = eleam_inicio_imagen(eleam_inicio_campo('imagen_pagina'), 'img-fluid hero-interior-imagen', $titulo, 'large', 'eager');
?>
<section class="hero-interior" aria-labelledby="titulo-pagina-infraestructura">
    <div class="container-fluid contenedor-amplio">
        <div class="row align-items-center">
            <div class="<?php echo $imagen !== '' ? 'col-md-6' : 'col-12'; ?> hero-interior-texto">
                <h1 id="titulo-pagina-infraestructura"><?php echo esc_html($titulo); ?></h1>
                <?php if ($bajada !== ''): ?><p><?php echo esc_html($bajada); ?></p><?php endif; ?>
            </div>
            <?php if ($imagen !== ''): ?>
                <div class="col-md-6"><?php echo $imagen; // HTML de wp_get_attachment_image() o helper validado. ?></div>
            <?php endif; ?>
        </div>
    </div>
</section>
