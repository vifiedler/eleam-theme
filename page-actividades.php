<?php
/**
 * Template Name: Actividades
 *
 * Página Actividades (ID 22). Grupos SCF:
 * - "ELEAM | Hero de páginas interiores": titulo_pagina, bajada_texto, imagen_pagina.
 * - "ELEAM | Actividades": titulo_seccion_1, tarjetas_actividades,
 *   titulo_seccion_2_actividades, galeria_actividades, titulo_seccion_3actividades.
 * Los talleres son entradas de la categoría "talleres".
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package eleam-theme
 */

get_header();

if ( ! function_exists( 'get_field' ) ) {
	function get_field() {
		return '';
	}
}

$t = function ( $campo ) {
	return esc_html( (string) get_field( $campo ) );
};

$src = function ( $img ) {
	return is_array( $img ) ? esc_url( $img['url'] ) : '';
};
$alt = function ( $img ) {
	return is_array( $img ) ? esc_attr( $img['alt'] ) : '';
};
?>

<main id="primary" class="site-main">
<?php
while ( have_posts() ) :
	the_post();

	$hero_titulo = get_field( 'titulo_pagina' ) ?: get_the_title();
	$hero_imagen = get_field( 'imagen_pagina' );

	// Galería: se descartan filas sin imagen y se agrupan de a 4 por mosaico.
	$galeria = array_filter(
		get_field( 'galeria_actividades' ) ?: array(),
		function ( $fila ) {
			return is_array( $fila['imagen_actividades_galeria'] );
		}
	);
	$diapositivas = array_chunk( array_values( $galeria ), 4 );
	$total        = count( $diapositivas );
	?>
	<div id="contenido">

		<!-- HERO -->
		<section class="hero-interior" aria-labelledby="titulo-pagina">
			<div class="container-fluid contenedor-amplio"><div class="row">
				<div class="col-md-6 hero-interior-texto"><h1 id="titulo-pagina"><?php echo esc_html( $hero_titulo ); ?></h1><p><?php echo $t( 'bajada_texto' ); ?></p></div>
				<?php if ( $hero_imagen ) : ?>
				<div class="col-md-6"><img src="<?php echo $src( $hero_imagen ); ?>" alt="<?php echo $alt( $hero_imagen ); ?>" class="img-fluid hero-interior-imagen"></div>
				<?php endif; ?>
			</div></div>
		</section>

		<!-- DISTINTAS MANERAS DE PARTICIPAR -->
		<?php include get_template_directory() . '/assets/modulos/modulo-actividades/loop-modulo-actividades.php'; ?>

		<!-- MOMENTOS DE LA VIDA COTIDIANA -->
		<?php if ( $total ) : ?>
		<section class="seccion-momentos" aria-labelledby="titulo-momentos">
			<div class="container">
				<header class="encabezado-seccion">
					<h2 id="titulo-momentos"><?php echo $t( 'titulo_seccion_2_actividades' ); ?></h2>
				</header>

				<div id="carrusel-momentos" class="carrusel-galeria" role="region" aria-roledescription="carrusel" aria-label="<?php echo esc_attr( get_field( 'titulo_seccion_2_actividades' ) ); ?>">
					<div class="galeria-carrusel">
						<?php foreach ( $diapositivas as $i => $piezas ) : ?>
						<div class="galeria-carrusel-diapositiva" role="group" aria-roledescription="diapositiva" aria-label="<?php echo esc_attr( ( $i + 1 ) . ' de ' . $total ); ?>">
							<div class="galeria-mosaico">
								<?php foreach ( $piezas as $j => $pieza ) : ?>
								<figure class="galeria-mosaico-pieza<?php echo 0 === $j ? ' galeria-mosaico-pieza-descripcion' : ''; ?>" data-rotulo="<?php echo esc_attr( $pieza['nombre_actividad'] ); ?>" tabindex="0">
									<img class="img-fluid" src="<?php echo $src( $pieza['imagen_actividades_galeria'] ); ?>" alt="<?php echo $alt( $pieza['imagen_actividades_galeria'] ); ?>" loading="lazy" decoding="async">
									<figcaption class="galeria-mosaico-pie"><?php echo esc_html( $pieza['descripcion_actividad_foto'] ); ?></figcaption>
								</figure>
								<?php endforeach; ?>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
					<div class="carrusel-controles">
						<button class="carrusel-flecha carrusel-flecha-anterior" type="button" aria-label="Mosaico anterior"><span class="bi bi-arrow-left" aria-hidden="true"></span></button>
						<div class="carrusel-posicion" aria-live="polite">
							<div class="carrusel-puntos" aria-hidden="true">
								<?php for ( $i = 0; $i < $total; $i++ ) : ?>
									<span<?php echo 0 === $i ? ' class="esta-activo"' : ''; ?>></span>
								<?php endfor; ?>
							</div>
							<span class="carrusel-contador"><?php echo esc_html( '1 de ' . $total ); ?></span>
						</div>
						<button class="carrusel-flecha carrusel-flecha-siguiente" type="button" aria-label="Mosaico siguiente"><span class="bi bi-arrow-right" aria-hidden="true"></span></button>
					</div>
				</div>
			</div>
		</section>
		<?php endif; ?>

		<!-- TALLERES (entradas de la categoría "talleres") -->
		<?php
		$talleres = new WP_Query(
			array(
				'post_type'      => 'post',
				'category_name'  => 'talleres',
				'posts_per_page' => 6,
				'orderby'        => 'date',
				'order'          => 'DESC',
			)
		);

		if ( $talleres->have_posts() ) :
			$ids = wp_list_pluck( $talleres->posts, 'ID' );
			?>
		<section class="seccion-talleres" aria-labelledby="titulo-talleres">
			<style>
				<?php foreach ( $ids as $id ) : ?>
				#taller-<?php echo (int) $id; ?>:checked ~ .panel-<?php echo (int) $id; ?> { display: flex; }
				#taller-<?php echo (int) $id; ?>:checked ~ .talleres-botones [for="taller-<?php echo (int) $id; ?>"] { border: 3px solid var(--eleam-azul); color: var(--eleam-azul); }
				#taller-<?php echo (int) $id; ?>:focus-visible ~ .talleres-botones [for="taller-<?php echo (int) $id; ?>"] { outline: 3px solid var(--eleam-azul); outline-offset: 3px; }
				<?php endforeach; ?>
			</style>
			<div class="container">
				<header class="encabezado-seccion">
					<h2 id="titulo-talleres"><?php echo $t( 'titulo_seccion_3actividades' ); ?></h2>
				</header>

				<!-- 1) Radios -->
				<?php foreach ( $ids as $n => $id ) : ?>
				<input type="radio" name="taller" id="taller-<?php echo (int) $id; ?>" class="taller-radio visually-hidden"<?php echo 0 === $n ? ' checked' : ''; ?>>
				<?php endforeach; ?>

				<!-- 2) Botones -->
				<div class="d-grid talleres-botones">
					<?php foreach ( $ids as $id ) : ?>
					<label for="taller-<?php echo (int) $id; ?>" class="taller-boton"><?php echo esc_html( get_the_title( $id ) ); ?></label>
					<?php endforeach; ?>
				</div>

				<!-- 3) Paneles -->
				<?php
				while ( $talleres->have_posts() ) :
					$talleres->the_post();
					?>
				<div class="flex-column flex-md-row taller-panel panel-<?php the_ID(); ?>">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'large', array( 'class' => 'taller-imagen', 'loading' => 'lazy' ) ); ?>
					<?php endif; ?>
					<div class="d-flex flex-column taller-contenido">
						<h3 class="taller-titulo"><?php the_title(); ?></h3>
						<p><?php echo esc_html( get_the_excerpt() ); ?></p>
						<a href="<?php the_permalink(); ?>" class="link-ver-mas"><?php esc_html_e( 'Ver más', 'eleam' ); ?> <i class="bi bi-arrow-right-short" aria-hidden="true"></i></a>
					</div>
				</div>
				<?php endwhile; ?>
			</div>
		</section>
			<?php
		endif;
		wp_reset_postdata();
		?>

	</div><!-- #contenido -->
	<?php
endwhile; // End of the loop.
?>
</main><!-- #primary -->

<?php
get_footer();
