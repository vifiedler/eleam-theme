<?php
/** Hero de Inicio, con carrusel de imágenes desde SCF. */
defined('ABSPATH') || exit;

$filas = eleam_inicio_campo('diapositivas_inicio', false, array());
$diapositivas = array();
foreach (is_array($filas) ? $filas : array() as $fila) {
    $imagen = eleam_inicio_imagen(isset($fila['imagen_diapositiva_inicio']) ? $fila['imagen_diapositiva_inicio'] : null, '', '', 'large', count($diapositivas) === 0 ? 'eager' : 'lazy');
    if ($imagen !== '') {
        $diapositivas[] = $imagen;
    }
}
$total = count($diapositivas);
$boton_conocer = eleam_inicio_enlace('boton_conocer_hogar_inicio', '/infraestructura/', 'Conoce el hogar');
$boton_contribuir = eleam_inicio_enlace('boton_contribuir_inicio', '/contribuye/', 'Contribuye');
$titulo = eleam_inicio_texto('titulo_hero_inicio', false, get_the_title());
$descripcion = eleam_inicio_texto('descripcion_hero_inicio');
?>
<section class="hero-inicio" aria-labelledby="titulo-inicio">
    <div class="contenedor-amplio">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-inicio-texto">
                <h1 id="titulo-inicio"><?php echo esc_html($titulo); ?></h1>
                <?php if ($descripcion !== ''): ?><p><?php echo esc_html($descripcion); ?></p><?php endif; ?>
                <div class="hero-inicio-acciones">
                    <?php eleam_inicio_boton($boton_conocer, 'boton-secundario'); ?>
                    <?php eleam_inicio_boton($boton_contribuir, 'boton-primario'); ?>
                </div>
            </div>
            <?php if ($total): ?>
                <div class="col-lg-6 hero-inicio-carrusel-contenedor">
                    <div id="carrusel-inicio" class="hero-inicio-carrusel" <?php if ($total > 1): ?>role="region" aria-roledescription="carrusel" aria-label="Galería de inicio"<?php endif; ?>>
                        <div class="hero-inicio-pista">
                            <?php foreach ($diapositivas as $indice => $imagen): ?>
                                <div class="hero-inicio-diapositiva" <?php if ($total > 1): ?>role="group" aria-roledescription="diapositiva" aria-label="<?php echo esc_attr(($indice + 1) . ' de ' . $total); ?>"<?php endif; ?>>
                                    <?php echo $imagen; // HTML seguro generado por eleam_inicio_imagen(). ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if ($total > 1): ?>
                            <div class="hero-inicio-controles">
                                <button class="hero-inicio-flecha hero-inicio-flecha-anterior" type="button" aria-label="Imagen anterior"><span class="bi bi-arrow-left" aria-hidden="true"></span></button>
                                <div class="hero-inicio-posicion" aria-live="polite">
                                    <div class="hero-inicio-puntos" aria-hidden="true">
                                        <?php foreach ($diapositivas as $indice => $imagen): ?><span<?php echo $indice === 0 ? ' class="esta-activo"' : ''; ?>></span><?php endforeach; ?>
                                    </div>
                                    <span class="hero-inicio-contador"><?php echo esc_html('1 de ' . $total); ?></span>
                                </div>
                                <button class="hero-inicio-flecha hero-inicio-flecha-siguiente" type="button" aria-label="Imagen siguiente"><span class="bi bi-arrow-right" aria-hidden="true"></span></button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
