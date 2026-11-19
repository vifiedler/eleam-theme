<!-- 5. CAPELLANÍA -->
<?php
$btn_cap = $lk('capellania_boton');
$santo_img = get_field('santo_imagen');
$santo_fecha = get_field('santo_fecha'); // Selector de fecha, formato de retorno Y-m-d.
?>
<section class="seccion capellania-inicio" aria-labelledby="titulo-capellania">
	<div class="container">
		<header class="encabezado-seccion">
			<h2 id="titulo-capellania"><?php echo $t('capellania_titulo'); ?></h2>
			<p><?php echo $t('capellania_texto'); ?></p>
		</header>

		<div class="row g-4 align-items-stretch">

			<!-- 7 columnas: Últimas actividades (entradas de la categoría "capellania") -->
			<div class="col-12 col-lg-7">
				<div class="capellania-publicaciones">
					<h3 class="capellania-publicaciones-titulo">
						<?php echo $t('capellania_publicaciones_titulo'); ?>
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
				<article class="card tarjeta tarjeta-santo-dia" aria-labelledby="titulo-santo-dia"
					data-santo-dia>
					<header class="santo-dia-cabecera">
						<p class="santo-dia-etiqueta"><?php echo $t('santo_etiqueta'); ?></p>
						<h3 class="santo-dia-nombre" id="titulo-santo-dia" data-santo-nombre>
							<?php echo $t('santo_nombre'); ?>
						</h3>
					</header>
					<figure class="santo-dia-imagen">
						<img src="<?php echo $src($santo_img); ?>" alt="<?php echo $alt($santo_img); ?>"
							loading="lazy" decoding="async" data-santo-imagen>
					</figure>
					<div class="santo-dia-contenido">
						<p class="santo-dia-fecha">
							<span class="bi bi-calendar3" aria-hidden="true"></span>
							<time datetime="<?php echo esc_attr($santo_fecha); ?>"
								data-santo-fecha><?php echo $santo_fecha ? esc_html(date_i18n('j \d\e F', strtotime($santo_fecha))) : ''; ?></time>
						</p>
						<p class="santo-dia-descripcion" data-santo-descripcion>
							<?php echo $t('santo_descripcion'); ?>
						</p>
					</div>
				</article>
			</div>
		</div>

		<div class="acciones-seccion">
			<a class="btn boton boton-secundario"
				href="<?php echo $btn_cap['url']; ?>"><?php echo $btn_cap['title']; ?> <span
					class="bi bi-arrow-right" aria-hidden="true"></span></a>
		</div>
	</div>
</section>