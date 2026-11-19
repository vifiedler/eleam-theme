<?php
/** Equipo profesional ELEAM: reutiliza SCF de ¿Quiénes somos?, sin duplicar contenido. */
defined('ABSPATH') || exit;
$titulo = eleam_transparencia_texto('titulo_profesionales_transparencia', false, 'Equipo profesional');
$descripcion = eleam_transparencia_texto('descripcion_profesionales_transparencia');
$quienes = get_page_by_path('quienes-somos');
if (!($quienes instanceof WP_Post)) {
    $quienes = get_page_by_path('nosotros');
}
$quienes_id = $quienes instanceof WP_Post ? (int) $quienes->ID : 0;
$directivos = $quienes_id ? eleam_transparencia_filas('tarjetas_equipo_directivo', $quienes_id) : array();
$directivos_visibles = array();
foreach ($directivos as $fila) {
    if (!empty($fila['mostrar_en_transparencia'])) {
        $directivos_visibles[] = $fila;
    }
}
$clinicos = $quienes_id ? eleam_transparencia_filas('tarjetas_equipo_clinico', $quienes_id) : array();
$nombre_directivos = $quienes_id ? eleam_transparencia_texto('subtitulo_equipo_directivo', $quienes_id, 'Dirección') : 'Dirección';
$nombre_clinicos = $quienes_id ? eleam_transparencia_texto('subtitulo_equipo_clinico', $quienes_id, 'Equipo clínico') : 'Equipo clínico';
?>
<section id="profesionales" class="seccion transparencia-profesionales" aria-labelledby="titulo-profesionales">
    <div class="container">
        <header class="encabezado-seccion">
            <h2 id="titulo-profesionales"><?php echo esc_html($titulo); ?></h2>
            <?php if ($descripcion !== ''): ?><p><?php echo esc_html($descripcion); ?></p><?php endif; ?>
        </header>
        <?php if ($directivos_visibles): ?>
            <h3 class="transparencia-subtitulo-equipo"><?php echo esc_html($nombre_directivos); ?></h3>
            <div class="row g-4 transparencia-bloque-equipo">
                <?php foreach ($directivos_visibles as $fila):
                    $nombre = isset($fila['nombre_directivo']) ? trim((string) $fila['nombre_directivo']) : '';
                    $cargo = isset($fila['cargo_directivo']) ? trim((string) $fila['cargo_directivo']) : '';
                    $profesion = isset($fila['profesion_directivo']) ? trim((string) $fila['profesion_directivo']) : '';
                    $detalle = isset($fila['texto_complementario_transparencia']) && trim((string) $fila['texto_complementario_transparencia']) !== '' ? trim((string) $fila['texto_complementario_transparencia']) : (isset($fila['lugar_de_trabajo_directivo']) ? trim((string) $fila['lugar_de_trabajo_directivo']) : '');
                    if ($nombre === '') { continue; }
                    $imagen = eleam_transparencia_imagen(isset($fila['imagen_directivo']) ? $fila['imagen_directivo'] : null, 'img-fluid card-img-top tarjeta-imagen', 'Retrato de ' . $nombre);
                ?>
                    <div class="col-sm-6 col-lg-4">
                        <article class="card tarjeta tarjeta-directorio h-100">
                            <?php if ($imagen !== ''): ?><?php echo $imagen; // Imagen segura del helper del tema. ?><?php else: ?><div class="transparencia-retrato-vacio" aria-hidden="true"><span class="bi bi-person"></span></div><?php endif; ?>
                            <div class="card-body">
                                <h4><?php echo esc_html($nombre); ?></h4>
                                <?php if ($cargo !== ''): ?><p><?php echo esc_html($cargo); ?></p><?php endif; ?>
                                <?php if ($profesion !== ''): ?><p class="texto-secundario"><?php echo esc_html($profesion); ?></p><?php endif; ?>
                                <?php if ($detalle !== ''): ?><small class="texto-secundario"><?php echo nl2br(esc_html($detalle)); ?></small><?php endif; ?>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if ($clinicos): ?>
            <h3 class="transparencia-subtitulo-equipo"><?php echo esc_html($nombre_clinicos); ?></h3>
            <div class="row g-4 transparencia-bloque-equipo">
                <?php foreach ($clinicos as $fila):
                    $nombre = isset($fila['nombre_clinico']) ? trim((string) $fila['nombre_clinico']) : '';
                    $profesion = isset($fila['subtitulo_profesion_clinico']) ? trim((string) $fila['subtitulo_profesion_clinico']) : '';
                    $detalle = isset($fila['descripcion_clinico']) ? trim((string) $fila['descripcion_clinico']) : '';
                    if ($nombre === '') { continue; }
                    $imagen = eleam_transparencia_imagen(isset($fila['imagen_clinico']) ? $fila['imagen_clinico'] : null, 'img-fluid card-img-top tarjeta-imagen', 'Retrato de ' . $nombre);
                ?>
                    <div class="col-sm-6 col-lg-3">
                        <article class="card tarjeta tarjeta-directorio h-100">
                            <?php if ($imagen !== ''): ?><?php echo $imagen; // Imagen segura del helper del tema. ?><?php else: ?><div class="transparencia-retrato-vacio" aria-hidden="true"><span class="bi bi-person"></span></div><?php endif; ?>
                            <div class="card-body">
                                <h4><?php echo esc_html($nombre); ?></h4>
                                <?php if ($profesion !== ''): ?><p class="texto-secundario"><?php echo esc_html($profesion); ?></p><?php endif; ?>
                                <?php if ($detalle !== ''): ?><small class="texto-secundario"><?php echo esc_html($detalle); ?></small><?php endif; ?>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (!$directivos_visibles && !$clinicos): ?>
            <p class="transparencia-sin-datos">La información del equipo profesional se encuentra pendiente de publicación.</p>
        <?php endif; ?>
    </div>
</section>
