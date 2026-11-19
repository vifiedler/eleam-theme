<div class="container">
	<div class="encabezado-seccion">
		<h2 id="titulo-galeria"><?php echo esc_html( get_field( 'titulo_seccion_2_capellania' ) ); ?></h2>
		<p class="text-center"><?php echo esc_html( get_field( 'texto_seccion_2_capellania' ) ); ?></p>
	</div>

	<?php if ( function_exists( 'have_rows' ) && have_rows( 'galeria_capellania' ) ) : ?>
		<div class="galeria-mosaico" role="group" aria-label="<?php echo esc_attr( get_field( 'titulo_seccion_2_capellania' ) ); ?>">
			<?php
			while ( have_rows( 'galeria_capellania' ) ) :
				the_row();

				$imagen      = get_sub_field( 'imagen_capellania' );
				$rotulo      = get_sub_field( 'etiqueta_foto_capellania' );
				$descripcion = get_sub_field( 'descripcion_foto_capellania' );
				$class_special = ( 1 === get_row_index() ) ? ' galeria-mosaico-pieza-descripcion' : '';
				?>

				<figure class="galeria-mosaico-pieza<?php echo esc_attr( $class_special ); ?>" data-rotulo="<?php echo esc_attr( $rotulo ); ?>" tabindex="0">
					<?php if ( is_array( $imagen ) && ! empty( $imagen['url'] ) ) : ?>
						<img class="img-fluid"
							src="<?php echo esc_url( $imagen['url'] ); ?>"
							alt="<?php echo esc_attr( isset( $imagen['alt'] ) && $imagen['alt'] ? $imagen['alt'] : $rotulo ); ?>"
							loading="lazy" decoding="async">
					<?php endif; ?>
					<figcaption class="galeria-mosaico-pie"><?php echo esc_html( $descripcion ); ?></figcaption>
				</figure>

			<?php endwhile; ?>
		</div>
	<?php endif; ?>
</div>