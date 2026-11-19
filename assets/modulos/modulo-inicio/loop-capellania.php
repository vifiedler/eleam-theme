<?php
/** Capellanía de Inicio: últimos tres posts de la categoría y santoral. */
defined('ABSPATH') || exit;

$titulo = eleam_inicio_texto('titulo_capellania_inicio', false, 'Fe, compañía y esperanza');
$descripcion = eleam_inicio_texto('descripcion_capellania_inicio');
$titulo_publicaciones = eleam_inicio_texto('titulo_publicaciones_capellania_inicio', false, 'Últimas actividades de capellanía');
$boton = eleam_inicio_enlace('boton_capellania_inicio', '/capellania/', 'Ver capellanía');
$capellania_id = get_page_by_path('capellania');
$pagina_capellania_id = $capellania_id instanceof WP_Post ? (int) $capellania_id->ID : 0;
$texto_ver = eleam_inicio_texto('texto_expandir_publicacion', $pagina_capellania_id, 'Ver más');
$texto_ocultar = eleam_inicio_texto('texto_colapsar_publicacion', $pagina_capellania_id, 'Ocultar detalle');

$publicaciones = new WP_Query(array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'category_name' => 'capellania',
    'posts_per_page' => 3,
    'ignore_sticky_posts' => true,
    'no_found_rows' => true,
));
?>
<section class="seccion capellania-inicio" aria-labelledby="titulo-capellania">
    <div class="container">
        <header class="encabezado-seccion">
            <h2 id="titulo-capellania"><?php echo esc_html($titulo); ?></h2>
            <?php if ($descripcion !== ''): ?><p><?php echo esc_html($descripcion); ?></p><?php endif; ?>
        </header>
        <div class="row g-4 align-items-stretch">
            <div class="col-12">
                <div class="capellania-publicaciones">
                    <h3 class="capellania-publicaciones-titulo"><?php echo esc_html($titulo_publicaciones); ?></h3>
                    <?php if ($publicaciones->have_posts()): ?>
                        <?php while ($publicaciones->have_posts()): $publicaciones->the_post();
                            $detalle_id = 'detalle-capellania-' . get_the_ID();
                            $extracto = get_the_excerpt();
                            $contenido = get_the_content();
                            ?>
                            <article class="publicacion" data-publicacion data-texto-expandir="<?php echo esc_attr($texto_ver); ?>" data-texto-colapsar="<?php echo esc_attr($texto_ocultar); ?>">
                                <time class="publicacion-fecha" datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>">
                                    <strong><?php echo esc_html(get_the_date('d')); ?></strong><?php echo esc_html(wp_date('M. Y', get_post_timestamp())); ?>
                                </time>
                                <div class="publicacion-contenido">
                                    <h4 class="publicacion-titulo"><?php echo esc_html(get_the_title()); ?></h4>
                                    <?php if ($extracto !== ''): ?><p class="publicacion-extracto"><?php echo esc_html($extracto); ?></p><?php endif; ?>
                                    <?php if (trim($contenido) !== ''): ?>
                                        <div class="publicacion-detalle collapse" id="<?php echo esc_attr($detalle_id); ?>">
                                            <?php echo apply_filters('the_content', $contenido); // Contenido WordPress con filtros nativos. ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if (trim($contenido) !== ''): ?>
                                    <button class="publicacion-control" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#<?php echo esc_attr($detalle_id); ?>" aria-expanded="false"
                                            aria-controls="<?php echo esc_attr($detalle_id); ?>">
                                        <span class="publicacion-control-texto"><?php echo esc_html($texto_ver); ?></span>
                                        <span class="bi bi-arrow-down" aria-hidden="true"></span>
                                    </button>
                                <?php endif; ?>
                            </article>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p><?php esc_html_e('Pronto compartiremos nuevas actividades de capellanía.', 'eleam-theme'); ?></p>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
            <div class="col-12">
                <?php get_template_part('assets/modulos/modulo-inicio/loop-santoral'); ?>
            </div>
        </div>
        <div class="acciones-seccion"><?php eleam_inicio_boton($boton); ?></div>
    </div>
</section>
