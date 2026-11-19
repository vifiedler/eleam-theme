<?php
/**
 * Template Name: Infraestructura
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
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

	$hero_imagen  = get_field( 'hero_imagen' );
	$diapositivas = get_field( 'galeria_diapositivas' ) ?: array();
	$total        = count( $diapositivas );
	?>
	<div id="contenido">

		<!-- HERO -->
		<section class="hero-interior" aria-labelledby="titulo-pagina">
			<div class="container-fluid contenedor-amplio">
				<div class="row">
					<div class="col-md-6 hero-interior-texto">
						<h1 id="titulo-pagina"><?php the_title(); ?></h1>
						<p><?php echo $t( 'hero_texto' ); ?></p>
					</div>
					<div class="col-md-6"><img src="<?php echo $src( $hero_imagen ); ?>" alt="<?php echo $alt( $hero_imagen ); ?>"
							class="img-fluid hero-interior-imagen" decoding="async"></div>
				</div>
			</div>
		</section>

		<!-- GALERÍA -->
		<section class="seccion" aria-labelledby="titulo-galeria">
			<div class="container">
				<header class="encabezado-seccion">
					<h2 id="titulo-galeria"><?php echo $t( 'galeria_titulo' ); ?></h2>
				</header>
				<?php if ( $total ) : ?>
				<div id="carrusel-infraestructura" class="carrusel-galeria" role="region" aria-roledescription="carrusel"
					aria-label="Galería de infraestructura">
					<div class="galeria-carrusel">
						<?php foreach ( $diapositivas as $i => $diapositiva ) : ?>
						<div class="galeria-carrusel-diapositiva" role="group" aria-roledescription="diapositiva"
							aria-label="<?php echo esc_attr( ( $i + 1 ) . ' de ' . $total ); ?>">
							<div class="galeria-mosaico">
								<?php foreach ( ( $diapositiva['piezas'] ?: array() ) as $j => $pieza ) : ?>
								<figure class="galeria-mosaico-pieza<?php echo 0 === $j ? ' galeria-mosaico-pieza-descripcion' : ''; ?>" data-rotulo="<?php echo esc_attr( $pieza['rotulo'] ); ?>"
									tabindex="0"><img class="img-fluid<?php echo $pieza['clase_imagen'] ? ' ' . esc_attr( $pieza['clase_imagen'] ) : ''; ?>" src="<?php echo $src( $pieza['imagen'] ); ?>"
										alt="<?php echo $alt( $pieza['imagen'] ); ?>" loading="lazy" decoding="async">
									<figcaption class="galeria-mosaico-pie"><?php echo esc_html( $pieza['descripcion'] ); ?></figcaption>
								</figure>
								<?php endforeach; ?>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
					<div class="carrusel-controles">
						<button class="carrusel-flecha carrusel-flecha-anterior" type="button" aria-label="Mosaico anterior"><span
								class="bi bi-arrow-left" aria-hidden="true"></span></button>
						<div class="carrusel-posicion" aria-live="polite">
							<div class="carrusel-puntos" aria-hidden="true">
								<?php foreach ( $diapositivas as $i => $diapositiva ) : ?>
									<span<?php echo 0 === $i ? ' class="esta-activo"' : ''; ?>></span>
								<?php endforeach; ?>
							</div>
							<span class="carrusel-contador"><?php echo esc_html( '1 de ' . $total ); ?></span>
						</div>
						<button class="carrusel-flecha carrusel-flecha-siguiente" type="button" aria-label="Mosaico siguiente"><span
								class="bi bi-arrow-right" aria-hidden="true"></span></button>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</section>

	</div><!-- #contenido -->
	<?php
endwhile; // End of the loop.
?>
</main><!-- #primary -->

<?php
get_footer();
