<?php
/** Directorio de Fundación Cáritas Melipilla, configurado en la página Transparencia. */
defined('ABSPATH') || exit;
$titulo = eleam_transparencia_texto('titulo_directorio_fundacion', false, 'Directorio de la Fundación');
$descripcion = eleam_transparencia_texto('descripcion_directorio_fundacion');
$filas = eleam_transparencia_filas('directorio_fundacion');
$destacados = array();
$restantes = array();
foreach ($filas as $fila) {
    if (!empty($fila['destacar_directorio_fundacion'])) {
        $destacados[] = $fila;
    } else {
        $restantes[] = $fila;
    }
}
?>
<section id="directorio" class="seccion transparencia-directorio" aria-labelledby="titulo-directorio">
    <div class="container">
        <header class="encabezado-seccion">
            <h2 id="titulo-directorio"><?php echo esc_html($titulo); ?></h2>
            <?php if ($descripcion !== ''): ?><p><?php echo esc_html($descripcion); ?></p><?php endif; ?>
        </header>
        <?php if ($filas): ?>
            <?php if ($destacados): ?>
                <div class="row justify-content-center g-4 mb-4">
                    <?php foreach ($destacados as $fila): ?>
                        <div class="col-sm-6 col-lg-5"><?php eleam_transparencia_tarjeta_directorio($fila, true); ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if ($restantes): ?>
                <div class="row justify-content-center g-4">
                    <?php foreach ($restantes as $fila): ?>
                        <div class="col-sm-6 col-lg-3"><?php eleam_transparencia_tarjeta_directorio($fila); ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p class="transparencia-sin-datos">La información del directorio se encuentra pendiente de publicación.</p>
        <?php endif; ?>
    </div>
</section>
