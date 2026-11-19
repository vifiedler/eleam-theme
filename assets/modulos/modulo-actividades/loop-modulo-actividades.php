<?php
/**
 * Sección "Distintas maneras de compartir y participar".
 *
 * Grupo SCF: "ELEAM | Actividades" (página Actividades, ID 22).
 * Se incluye dentro del loop de page-actividades.php, por lo que
 * get_field() y have_rows() leen los campos de la página actual.
 *
 * Campos:
 * - titulo_seccion_1 (texto)
 * - tarjetas_actividades (repetidor)
 *   - titulo_tarj_actividades       (texto)
 *   - descripcion_actividad_tarjeta (área de texto)
 *   - imagen_tarjeta                (imagen, array)
 *   - enlace_a_actividad            (enlace, array, opcional)
 *
 * @package eleam-theme
 */

$titulo_seccion = get_field( 'titulo_seccion_1' );

if ( have_rows( 'tarjetas_actividades' ) ) : ?>

	<section class="seccion-participar" aria-labelledby="titulo-participar">
		<div class="container">
			<header class="encabezado-seccion">
				<h2 id="titulo-participar"><?php echo esc_html( $titulo_seccion ); ?></h2>
			</header>

			<div class="d-grid grilla-tarjetas">
				<?php
				while ( have_rows( 'tarjetas_actividades' ) ) :
					the_row();

					$titulo = get_sub_field( 'titulo_tarj_actividades' );
					$texto  = get_sub_field( 'descripcion_actividad_tarjeta' );
					$imagen = get_sub_field( 'imagen_tarjeta' );
					$enlace = get_sub_field( 'enlace_a_actividad' ); // Opcional.

					$tiene_enlace = is_array( $enlace ) && ! empty( $enlace['url'] );
					$enlace_texto = $tiene_enlace && ! empty( $enlace['title'] ) ? $enlace['title'] : __( 'Ver más', 'eleam' );
					$enlace_dest  = $tiene_enlace && ! empty( $enlace['target'] ) ? $enlace['target'] : '_self';
					?>

					<article class="card tarjeta d-flex flex-row">
						<?php if ( ! empty( $imagen ) ) : ?>
							<div class="flex-shrink-0 position-relative tarjeta-participar-media">
								<img src="<?php echo esc_url( $imagen['url'] ); ?>"
									alt="<?php echo esc_attr( $imagen['alt'] ); ?>"
									class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" loading="lazy" decoding="async">
							</div>
						<?php endif; ?>
						<div class="card-body d-flex flex-column justify-content-center">
							<h3 class="card-title"><?php echo esc_html( $titulo ); ?></h3>
							<p class="card-text"><?php echo esc_html( $texto ); ?></p>
							<?php if ( $tiene_enlace ) : ?>
								<a href="<?php echo esc_url( $enlace['url'] ); ?>" target="<?php echo esc_attr( $enlace_dest ); ?>" class="link-ver-mas"><?php echo esc_html( $enlace_texto ); ?> <i class="bi bi-arrow-right-short" aria-hidden="true"></i></a>
							<?php endif; ?>
						</div>
					</article>

				<?php endwhile; ?>
			</div>
		</div>
	</section>

<?php endif; ?>
