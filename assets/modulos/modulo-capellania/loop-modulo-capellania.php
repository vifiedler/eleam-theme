<section class="seccion" aria-labelledby="titulo-galeria">
	<div class="container">
		<div class="encabezado-seccion">
			<h2 id="titulo-galeria"><?php echo esc_html(get_field('titulo_seccion_2_capellania')); ?></h2>
			<p class="text-center"><?php echo esc_html(get_field('texto_seccion_2_capellania')); ?></p>
		</div>

		<?php if (function_exists('have_rows') && have_rows('galeria_capellania')): ?>
			<div class="galeria-mosaico" role="group"
				aria-label="<?php echo esc_attr(get_field('titulo_seccion_2_capellania')); ?>">
				<?php
				while (have_rows('galeria_capellania')):
					the_row();

					$imagen = get_sub_field('imagen_capellania');
					$rotulo = get_sub_field('etiqueta_foto_capellania');
					$descripcion = get_sub_field('descripcion_foto_capellania');
					$class_special = (1 === get_row_index()) ? ' galeria-mosaico-pieza-descripcion' : '';
					?>

					<figure class="galeria-mosaico-pieza<?php echo esc_attr($class_special); ?>"
						data-rotulo="<?php echo esc_attr($rotulo); ?>" tabindex="0">
						<?php if (is_array($imagen) && !empty($imagen['url'])): ?>
							<img class="img-fluid" src="<?php echo esc_url($imagen['url']); ?>"
								alt="<?php echo esc_attr(isset($imagen['alt']) && $imagen['alt'] ? $imagen['alt'] : $rotulo); ?>"
								loading="lazy" decoding="async">
						<?php endif; ?>
						<figcaption class="galeria-mosaico-pie"><?php echo esc_html($descripcion); ?></figcaption>
					</figure>

				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<section class="seccion seccion-crema" aria-labelledby="titulo-calendario-liturgico">
	<div class="container">
		<div class="encabezado-seccion">
			<h2 id="titulo-calendario-liturgico"><?php echo esc_html(get_field('titulo_calendario_liturgico')); ?>
			</h2>
			<p class="text-center"><?php echo esc_html(get_field('texto_calendario_liturgico')); ?></p>
		</div>
	</div>
</section>

<?php if (function_exists('have_rows') && have_rows('eventos_calendario_liturgico')): ?>
	<section class="calendario-liturgico seccion-crema pb-5" role="group"
		aria-label="<?php echo esc_attr(get_field('titulo_calendario_liturgico')); ?>">
		<div class="calendario-liturgico-linea" aria-hidden="true"></div>
		<div class="container calendario-liturgico-pista">
			<?php
			while (have_rows('eventos_calendario_liturgico')):
				the_row();

				$titulo = get_sub_field('titulo_hito_liturgico');

				// "false" devuelve el valor guardado (Ymd), sin depender del formato de retorno del campo.
				$inicio = get_sub_field('fecha_inicio_liturgica', false);
				$termino = get_sub_field('fecha_termino_liturgica', false);

				$ts_inicio = $inicio ? strtotime($inicio) : false;
				$ts_termino = $termino ? strtotime($termino) : false;

				$fecha_attr = $ts_inicio ? date_i18n('Y-m-d', $ts_inicio) : '';
				$fecha_texto = $ts_inicio ? date_i18n('j \d\e F', $ts_inicio) : '';

				// Si hay rango (término distinto del inicio): "30 de marzo al 3 de abril".
				if ($ts_inicio && $ts_termino && $ts_termino !== $ts_inicio) {
					$fecha_texto .= ' al ' . date_i18n('j \d\e F', $ts_termino);
				}
				?>
				<article class="calendario-liturgico-hito">
					<div class="calendario-liturgico-tarjeta">
						<h3><?php echo esc_html($titulo); ?></h3>
					</div>
					<time datetime="<?php echo esc_attr($fecha_attr); ?>"><?php echo esc_html($fecha_texto); ?></time>
				</article>
			<?php endwhile; ?>
		</div>
		<div class="calendario-liturgico-controles" role="group" aria-label="Controles del calendario litúrgico">
			<button type="button" class="calendario-liturgico-control" data-calendario-accion="anterior"
				aria-label="Hito anterior">
				<i class="bi bi-chevron-left" aria-hidden="true"></i>
			</button>
			<button type="button" class="calendario-liturgico-control" data-calendario-accion="reproducir"
				aria-label="Reproducir calendario">
				<i class="bi bi-play-fill" aria-hidden="true"></i>
			</button>
			<button type="button" class="calendario-liturgico-control" data-calendario-accion="siguiente"
				aria-label="Siguiente hito">
				<i class="bi bi-chevron-right" aria-hidden="true"></i>
			</button>
		</div>
	</section>
<?php endif; ?>

<?php
// Textos de la PÁGINA: se leen antes del loop, porque dentro de la consulta get_field() lee la entrada actual.
$titulo_pub = get_field( 'titulo_actividades_liturgicas' );
$texto_pub  = get_field( 'contenido_actividades_liturgicas' );
$ver_mas    = get_field( 'texto_expandir_publicacion' ) ?: 'Ver más';

$capellania_query = new WP_Query( array(
	'post_type'           => 'post',
	'category_name'       => 'capellania',
	'orderby'             => 'date',
	'order'               => 'DESC',
	'posts_per_page'      => 6,
	'ignore_sticky_posts' => true,
) );

if ( $capellania_query->have_posts() ) : ?>
<section class="seccion" aria-labelledby="titulo-publicaciones">
	<div class="container">
		<header class="encabezado-seccion">
			<h2 id="titulo-publicaciones"><?php echo esc_html( $titulo_pub ); ?></h2>
			<p class="text-center"><?php echo esc_html( $texto_pub ); ?></p>
		</header>

		<?php
		while ( $capellania_query->have_posts() ) :
			$capellania_query->the_post();
			$detalle_id = 'detalle-capellania-' . get_the_ID();
			?>
			<article class="publicacion" data-publicacion>
				<time class="publicacion-fecha" datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><strong><?php echo esc_html( get_the_date( 'd' ) ); ?></strong><?php echo esc_html( date_i18n( 'M. Y', get_post_timestamp() ) ); ?></time>
				<div>
					<h3 class="publicacion-titulo"><?php the_title(); ?></h3>
					<p class="publicacion-extracto"><?php echo esc_html( get_the_excerpt() ); ?></p>
					<div class="publicacion-detalle collapse" id="<?php echo esc_attr( $detalle_id ); ?>">
						<?php the_content(); ?>
					</div>
				</div>
				<button class="publicacion-control" type="button" data-bs-toggle="collapse"
					data-bs-target="#<?php echo esc_attr( $detalle_id ); ?>" aria-expanded="false" aria-controls="<?php echo esc_attr( $detalle_id ); ?>">
					<span class="publicacion-control-texto"><?php echo esc_html( $ver_mas ); ?></span>
					<span class="bi bi-arrow-down" aria-hidden="true"></span>
				</button>
			</article>
		<?php endwhile; ?>
	</div>
</section>
<?php
	wp_reset_postdata();
endif;
?>