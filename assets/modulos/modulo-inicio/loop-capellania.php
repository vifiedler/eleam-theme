<?php
/** Módulo de Capellanía en Inicio: noticias y tarjeta de santoral. */
defined('ABSPATH') || exit;

$valor_campo = static function ($nuevo, $antiguo = '') {
    $valor = function_exists('get_field') ? get_field($nuevo) : null;
    if (($valor === null || $valor === '' || $valor === false) && $antiguo !== '') {
        $valor = function_exists('get_field') ? get_field($antiguo) : null;
    }
    return $valor;
};
$t = static function ($nuevo, $antiguo = '') use ($valor_campo) {
    return esc_html((string) $valor_campo($nuevo, $antiguo));
};
$btn_cap = $valor_campo('boton_capellania_inicio', 'capellania_boton');
$btn_cap = is_array($btn_cap) ? $btn_cap : array();
$btn_cap_url = !empty($btn_cap['url']) ? esc_url($btn_cap['url']) : '';
$btn_cap_titulo = !empty($btn_cap['title']) ? esc_html($btn_cap['title']) : '';
?>
<section class="seccion capellania-inicio" aria-labelledby="titulo-capellania">
	<div class="container">
		<header class="encabezado-seccion">
			<h2 id="titulo-capellania"><?php echo $t('titulo_capellania_inicio', 'capellania_titulo'); ?></h2>
			<p><?php echo $t('descripcion_capellania_inicio', 'capellania_texto'); ?></p>
		</header>

		<div class="row g-4 align-items-stretch">

			<!-- 7 columnas: Últimas actividades (entradas de la categoría "capellania") -->
			<div class="col-12 col-lg-7">
				<div class="capellania-publicaciones">
					<h3 class="capellania-publicaciones-titulo">
						<?php echo $t('titulo_publicaciones_capellania_inicio', 'capellania_publicaciones_titulo'); ?>
					</h3>

					<?php
					$capellania_query = new WP_Query(
						array(
							'post_type' => 'post',
							'category_name' => 'capellania',
							'posts_per_page' => 3,
							'ignore_sticky_posts' => true,
						)
					);

					if ($capellania_query->have_posts()):
						while ($capellania_query->have_posts()):
							$capellania_query->the_post();
							$detalle_id = 'detalle-capellania-' . get_the_ID();
							?>
							<article class="publicacion" data-publicacion>
								<time class="publicacion-fecha"
									datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"><strong><?php echo esc_html(get_the_date('d')); ?></strong><?php echo esc_html(date_i18n('M. Y', get_post_timestamp())); ?></time>
								<div>
									<h4 class="publicacion-titulo"><?php the_title(); ?></h4>
									<p class="publicacion-extracto"><?php echo esc_html(get_the_excerpt()); ?></p>
									<div class="publicacion-detalle collapse" id="<?php echo esc_attr($detalle_id); ?>">
										<?php the_content(); ?>
									</div>
								</div>
								<button class="publicacion-control" type="button" data-bs-toggle="collapse"
									data-bs-target="#<?php echo esc_attr($detalle_id); ?>" aria-expanded="false"
									aria-controls="<?php echo esc_attr($detalle_id); ?>">
									<span class="publicacion-control-texto">Ver más</span>
									<span class="bi bi-arrow-down" aria-hidden="true"></span>
								</button>
							</article>
							<?php
						endwhile;
						wp_reset_postdata();
					endif;
					?>
				</div>
			</div>

			<!-- 5 columnas: Santo del Día -->
			<div class="col-12 col-lg-5">
				<?php get_template_part('assets/modulos/modulo-inicio/loop-santoral'); ?>
			</div>
		</div>

		<div class="acciones-seccion">
			<a class="btn boton boton-secundario"
				href="<?php echo $btn_cap_url ?: esc_url(home_url('/capellania/')); ?>"><?php echo $btn_cap_titulo !== '' ? $btn_cap_titulo : 'Ver capellanía'; ?> <span
					class="bi bi-arrow-right" aria-hidden="true"></span></a>
		</div>
	</div>
</section>