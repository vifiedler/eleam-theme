<?php
$temp = $wp_query;
$args = array(
	'post_type'      => 'galeria',  
	'orderby'        => 'date',
	'order'          => 'ASC',
	'posts_per_page' => 1,
);
$wp_query = new WP_Query( $args );

if ( $wp_query->have_posts() ) :
	while ( $wp_query->have_posts() ) :
		$wp_query->the_post(); ?>

		<section class="seccion" aria-labelledby="titulo-galeria">
			<div class="container">
				<div class="encabezado-seccion">
					<h2 id="titulo-galeria"><?php the_title(); ?></h2>
					<p class="text-center"><?php echo esc_html( get_the_excerpt() ); ?></p>
				</div>

				<div class="galeria-mosaico" role="group" aria-label="<?php echo esc_attr( get_field( 'galeria_etiqueta' ) ); ?>">
					<?php
					if ( have_rows( 'galeria_piezas' ) ) :
						while ( have_rows( 'galeria_piezas' ) ) :
							the_row();

							// Subcampos
							$imagen      = get_sub_field( 'imagen' );
							$rotulo      = get_sub_field( 'rotulo' );
							$descripcion = get_sub_field( 'descripcion' );
							$clase_img   = get_sub_field( 'clase_imagen' );
							$class_special = ( 1 === get_row_index() ) ? ' galeria-mosaico-pieza-descripcion' : '';
							?>

							<figure class="galeria-mosaico-pieza<?php echo esc_attr( $class_special ); ?>" data-rotulo="<?php echo esc_attr( $rotulo ); ?>" tabindex="0">
								<?php if ( ! empty( $imagen ) ) : ?>
									<img class="img-fluid<?php echo $clase_img ? ' ' . esc_attr( $clase_img ) : ''; ?>"
										src="<?php echo esc_url( $imagen['url'] ); ?>"
										alt="<?php echo esc_attr( $imagen['alt'] ); ?>"
										loading="lazy" decoding="async">
								<?php endif; ?>
								<figcaption class="galeria-mosaico-pie"><?php echo esc_html( $descripcion ); ?></figcaption>
							</figure>

						<?php endwhile;
					endif; // FIN DEL REPETIDOR ?>
				</div>
			</div>
		</section>

	<?php endwhile;
endif;
wp_reset_query();
$wp_query = $temp;
?>