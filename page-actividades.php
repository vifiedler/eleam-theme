<?php
/**
 * Template Name: Actividades
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

$ps = function ( $texto ) {
	return wpautop( esc_html( (string) $texto ) );
};

$lv = function ( $l ) {
	return is_array( $l )
		? array( 'url' => esc_url( $l['url'] ), 'title' => esc_html( $l['title'] ) )
		: array( 'url' => '#', 'title' => '' );
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
	$tarjetas     = get_field( 'participar_tarjetas' ) ?: array();
	$diapositivas = get_field( 'momentos_diapositivas' ) ?: array();
	$total        = count( $diapositivas );
	$talleres     = get_field( 'talleres' ) ?: array();
	?>
	<div id="contenido">

		<!-- HERO -->
		<section class="hero-interior" aria-labelledby="titulo-pagina">
			<div class="container-fluid contenedor-amplio"><div class="row">
				<div class="col-md-6 hero-interior-texto"><h1 id="titulo-pagina"><?php the_title(); ?></h1><p><?php echo $t( 'hero_texto' ); ?></p></div>
				<div class="col-md-6"><img src="<?php echo $src( $hero_imagen ); ?>" alt="<?php echo $alt( $hero_imagen ); ?>" class="img-fluid hero-interior-imagen"></div>
			</div></div>
		</section>

		<!-- DISTINTAS MANERAS DE PARTICIPAR -->
		<section class="seccion-participar" aria-labelledby="titulo-participar">
			<div class="container">
				<header class="encabezado-seccion">
					<h2 id="titulo-participar"><?php echo $t( 'participar_titulo' ); ?></h2>
				</header>

				<div class="d-grid grilla-tarjetas">
					<?php foreach ( $tarjetas as $c ) : ?>
						<?php $enlace = $lv( $c['enlace'] ); ?>
					<article class="card tarjeta d-flex flex-row">
						<a href="<?php echo $enlace['url']; ?>" class="flex-shrink-0" style="width: 38%;">
							<img src="<?php echo $src( $c['imagen'] ); ?>" alt="<?php echo $alt( $c['imagen'] ); ?>" class="w-100 h-100 object-fit-cover">
						</a>
						<div class="card-body d-flex flex-column justify-content-center">
							<h3 class="card-title"><?php echo esc_html( $c['titulo'] ); ?></h3>
							<p class="card-text"><?php echo esc_html( $c['texto'] ); ?></p>
							<a href="<?php echo $enlace['url']; ?>" class="link-ver-mas"><?php echo $enlace['title'] ?: esc_html__( 'Ver más', 'eleam' ); ?> <i class="bi bi-arrow-right-short" aria-hidden="true"></i></a>
						</div>
					</article>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<!-- MOMENTOS DE LA VIDA COTIDIANA -->
		<section class="seccion-momentos" aria-labelledby="titulo-momentos">
			<div class="container">
				<header class="encabezado-seccion">
					<h2 id="titulo-momentos"><?php echo $t( 'momentos_titulo' ); ?></h2>
				</header>

				<?php if ( $total ) : ?>
				<div id="carrusel-momentos" class="carrusel-galeria" role="region" aria-roledescription="carrusel" aria-label="<?php echo esc_attr( get_field( 'momentos_etiqueta' ) ); ?>">
					<div class="galeria-carrusel">
						<?php foreach ( $diapositivas as $i => $diapositiva ) : ?>
						<div class="galeria-carrusel-diapositiva" role="group" aria-roledescription="diapositiva" aria-label="<?php echo esc_attr( ( $i + 1 ) . ' de ' . $total ); ?>">
							<div class="galeria-mosaico">
								<?php foreach ( ( $diapositiva['piezas'] ?: array() ) as $j => $pieza ) : ?>
								<figure class="galeria-mosaico-pieza<?php echo 0 === $j ? ' galeria-mosaico-pieza-descripcion' : ''; ?>" data-rotulo="<?php echo esc_attr( $pieza['rotulo'] ); ?>" tabindex="0">
									<img class="img-fluid" src="<?php echo $src( $pieza['imagen'] ); ?>" alt="<?php echo $alt( $pieza['imagen'] ); ?>" loading="lazy" decoding="async">
									<figcaption class="galeria-mosaico-pie"><?php echo esc_html( $pieza['descripcion'] ); ?></figcaption>
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
								<?php foreach ( $diapositivas as $i => $diapositiva ) : ?>
									<span<?php echo 0 === $i ? ' class="esta-activo"' : ''; ?>></span>
								<?php endforeach; ?>
							</div>
							<span class="carrusel-contador"><?php echo esc_html( '1 de ' . $total ); ?></span>
						</div>
						<button class="carrusel-flecha carrusel-flecha-siguiente" type="button" aria-label="Mosaico siguiente"><span class="bi bi-arrow-right" aria-hidden="true"></span></button>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</section>

		<!-- TALLERES -->
		<section class="seccion-talleres" aria-labelledby="titulo-talleres">
			<div class="container">
				<header class="encabezado-seccion">
					<h2 id="titulo-talleres"><?php echo $t( 'talleres_titulo' ); ?></h2>
				</header>

				<?php
				//Radios.
				$primero = true;
				foreach ( $talleres as $taller ) :
					$slug = sanitize_title( $taller['slug'] );
					if ( ! $slug ) {
						continue;
					}
					?>
				<input type="radio" name="taller" id="taller-<?php echo esc_attr( $slug ); ?>" class="taller-radio visually-hidden"<?php echo $primero ? ' checked' : ''; ?>>
					<?php
					$primero = false;
				endforeach;
				?>

				<!--Botones 2 -->
				<div class="d-grid talleres-botones">
					<?php foreach ( $talleres as $taller ) : ?>
						<?php $slug = sanitize_title( $taller['slug'] ); ?>
						<?php if ( $slug ) : ?>
					<label for="taller-<?php echo esc_attr( $slug ); ?>" class="taller-boton"><?php echo esc_html( $taller['nombre'] ); ?></label>
						<?php else : ?>
					<button type="button" class="taller-boton"><?php echo esc_html( $taller['nombre'] ); ?></button>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>

				<!-- 3) Paneles (solo talleres con "slug") -->
				<?php foreach ( $talleres as $taller ) : ?>
					<?php
					$slug = sanitize_title( $taller['slug'] );
					if ( ! $slug ) {
						continue;
					}
					?>
				<div class="flex-column flex-md-row taller-panel panel-<?php echo esc_attr( $slug ); ?>">
					<img src="<?php echo $src( $taller['imagen'] ); ?>" alt="<?php echo $alt( $taller['imagen'] ); ?>" class="taller-imagen">
					<div class="d-flex flex-column taller-contenido">
						<h3 class="taller-titulo"><?php echo esc_html( $taller['titulo'] ); ?></h3>
						<?php echo $ps( $taller['texto'] ); ?>
						<button type="button" class="link-ver-mas"><?php esc_html_e( 'Ver más', 'eleam' ); ?> <i class="bi bi-arrow-right-short" aria-hidden="true"></i></button>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</section>

	</div><!-- #contenido -->
	<?php
endwhile; // End of the loop.
?>
</main><!-- #primary -->

<?php
get_footer();
