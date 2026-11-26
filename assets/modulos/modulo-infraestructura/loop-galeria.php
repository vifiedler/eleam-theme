<?php
/** Galería de Infraestructura: cada diapositiva contiene hasta cuatro fotos SCF. */
defined('ABSPATH') || exit;
$titulo = eleam_inicio_texto('titulo_infraestructura', false, 'Nuestra infraestructura');
$fotografias = eleam_infraestructura_fotografias();
$diapositivas = array_chunk($fotografias, 4);
$total = count($diapositivas);
$es_carrusel = $total > 1;
?>
<section class="seccion" aria-labelledby="titulo-galeria-infraestructura">
    <div class="container">
        <header class="encabezado-seccion">
            <h2 id="titulo-galeria-infraestructura"><?php echo esc_html($titulo); ?></h2>
        </header>
        <?php if ($total > 0): ?>
            <div id="carrusel-infraestructura" class="<?php echo $es_carrusel ? 'carrusel-galeria' : 'galeria-estatica'; ?>"
                <?php if ($es_carrusel): ?>role="region" aria-roledescription="carrusel" aria-label="Galería de infraestructura"<?php endif; ?>>
                <div class="galeria-carrusel">
                    <?php foreach ($diapositivas as $indice => $piezas): ?>
                        <div class="galeria-carrusel-diapositiva"
                            <?php if ($es_carrusel): ?>role="group" aria-roledescription="diapositiva" aria-label="<?php echo esc_attr(($indice + 1) . ' de ' . $total); ?>"<?php endif; ?>>
                            <div class="galeria-mosaico<?php echo count($piezas) < 4 ? ' galeria-mosaico--' . count($piezas) : ''; ?>">
                                <?php foreach ($piezas as $pieza): ?>
                                    <figure class="galeria-mosaico-pieza" data-rotulo="<?php echo esc_attr($pieza['rotulo']); ?>" tabindex="0">
                                        <?php echo $pieza['imagen']; // Imagen de helper validado. ?>
                                        <figcaption class="galeria-mosaico-pie"><?php echo esc_html($pieza['descripcion'] !== '' ? $pieza['descripcion'] : $pieza['rotulo']); ?></figcaption>
                                    </figure>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if ($es_carrusel): ?>
                    <div class="carrusel-controles">
                        <button class="carrusel-flecha carrusel-flecha-anterior" type="button" aria-label="Mosaico anterior"><span class="bi bi-arrow-left" aria-hidden="true"></span></button>
                        <div class="carrusel-posicion" aria-live="polite">
                            <div class="carrusel-puntos" aria-hidden="true">
                                <?php foreach ($diapositivas as $indice => $piezas): ?>
                                    <span<?php echo $indice === 0 ? ' class="esta-activo"' : ''; ?>></span>
                                <?php endforeach; ?>
                            </div>
                            <span class="carrusel-contador"><?php echo esc_html('1 de ' . $total); ?></span>
                        </div>
                        <button class="carrusel-flecha carrusel-flecha-siguiente" type="button" aria-label="Mosaico siguiente"><span class="bi bi-arrow-right" aria-hidden="true"></span></button>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p>Actualmente no hay fotografías de infraestructura disponibles.</p>
        <?php endif; ?>
    </div>
</section>
