<?php
/** Encabezado de Transparencia con imagen y texto SCF. */
defined('ABSPATH') || exit;
$titulo = eleam_transparencia_texto('titulo_pagina', false, get_the_title());
$bajada = eleam_transparencia_texto('bajada_texto');
$imagen = eleam_transparencia_imagen(eleam_transparencia_campo('imagen_pagina'), 'img-fluid hero-interior-imagen', $titulo, 'large', 'eager');
?>
<section class="hero-interior" aria-labelledby="titulo-pagina">
    <div class="container-fluid contenedor-amplio">
        <div class="row align-items-center">
            <div class="<?php echo $imagen !== '' ? 'col-md-6' : 'col-12'; ?> hero-interior-texto">
                <h1 id="titulo-pagina"><?php echo esc_html($titulo); ?></h1>
                <?php if ($bajada !== ''): ?><p><?php echo esc_html($bajada); ?></p><?php endif; ?>
            </div>
            <?php if ($imagen !== ''): ?>
                <div class="col-md-6"><?php echo $imagen; // Imagen segura del helper del tema. ?></div>
            <?php endif; ?>
        </div>
    </div>
</section>
