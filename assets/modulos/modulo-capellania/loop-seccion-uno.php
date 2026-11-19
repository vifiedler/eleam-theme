<?php
/** Primera sección de Capellanía: título y párrafos tal como en el HTML estático. */
defined('ABSPATH') || exit;

$titulo = eleam_interior_texto('titulo_seccion_1_capellania');
$contenido = eleam_interior_campo('contenido_seccion_1_capellania');
$contenido = is_string($contenido) ? trim($contenido) : '';

if ($contenido !== '') {
    // SCF ya guarda los párrafos como HTML. No volver a aplicar wpautop():
    // introduciría saltos <br> dentro del texto editorial.
    $contenido = preg_replace('~<br\b[^>]*>~i', ' ', $contenido);
    if (stripos($contenido, '<p') === false) {
        // Compatibilidad si en el futuro el campo pasa a texto plano.
        $contenido = wpautop($contenido, false);
    }
}
?>
<section class="seccion seccion-crema capellania-introduccion" aria-labelledby="titulo-introduccion-capellania">
    <div class="container">
        <div class="encabezado-seccion">
            <h2 id="titulo-introduccion-capellania"><?php echo esc_html($titulo); ?></h2>
            <?php if ($contenido !== ''): ?>
                <div class="capellania-introduccion-texto">
                    <?php echo wp_kses_post($contenido); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
