<?php
/** Uso de aportes: tarjetas SCF. */
defined('ABSPATH') || exit;
$titulo = eleam_transparencia_texto('titulo_seccion_2_transparencia', false, 'Uso de aportes');
$texto = eleam_transparencia_texto('contenido_seccion_2_transparencia');
$tarjetas = eleam_transparencia_filas('tarjetas_transparencia');
?>
<section id="aportes" class="seccion seccion-crema transparencia-aportes" aria-labelledby="titulo-aportes">
    <div class="container">
        <header class="encabezado-seccion">
            <h2 id="titulo-aportes"><?php echo esc_html($titulo); ?></h2>
            <?php if ($texto !== ''): ?><p><?php echo esc_html($texto); ?></p><?php endif; ?>
        </header>
        <?php if ($tarjetas): ?>
            <div class="row g-4">
                <?php foreach ($tarjetas as $tarjeta):
                    $nombre = isset($tarjeta['titulo_tarjeta_transparencia']) ? trim((string) $tarjeta['titulo_tarjeta_transparencia']) : '';
                    $descripcion = isset($tarjeta['contenido_tarjeta_transparencia']) ? trim((string) $tarjeta['contenido_tarjeta_transparencia']) : '';
                    if ($nombre === '' && $descripcion === '') { continue; }
                ?>
                    <div class="col-md-4">
                        <article class="card tarjeta h-100">
                            <div class="card-body">
                                <?php if ($nombre !== ''): ?><h3 class="documento-titulo"><?php echo esc_html($nombre); ?></h3><?php endif; ?>
                                <?php if ($descripcion !== ''): ?><p><?php echo esc_html($descripcion); ?></p><?php endif; ?>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="transparencia-sin-datos">La información sobre el uso de aportes estará disponible próximamente.</p>
        <?php endif; ?>
    </div>
</section>
