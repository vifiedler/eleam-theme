<?php
/**
 * Template Name: Contacto
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

$lk = function ( $campo ) {
	$l = get_field( $campo );
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

	$hero_imagen = get_field( 'hero_imagen' );
	$mapa        = get_field( 'contacto_mapa' );
	$btn_banner  = $lk( 'banner_boton' );
	?>
	<div id="contenido">

		<!-- HERO -->
		<section class="hero-interior" aria-labelledby="titulo-contacto">
			<div class="contenedor-amplio">
				<div class="row">
					<div class="col-md-6 hero-interior-texto">
						<h1 id="titulo-contacto"><?php the_title(); ?></h1>
						<p><?php echo $t( 'hero_texto' ); ?></p>
					</div>
					<div class="col-md-6">
						<img class="hero-interior-imagen" src="<?php echo $src( $hero_imagen ); ?>"
							alt="<?php echo $alt( $hero_imagen ); ?>" width="720" height="340">
					</div>
				</div>
			</div>
		</section>

		<!-- INFORMACIÓN Y FORMULARIO -->
					<?php include get_template_directory() . '/assets/modulos/modulo-inicio/loop-contacto.php'; ?>


		<!-- BANNER CONTRIBUCIÓN -->
		<section class="banner-contribucion" aria-labelledby="titulo-contribucion">
			<div class="contenedor-contenido">
				<h2 id="titulo-contribucion"><?php echo $t( 'banner_titulo' ); ?></h2>
				<p><?php echo $t( 'banner_texto' ); ?></p>
				<a class="btn boton boton-primario" href="<?php echo $btn_banner['url']; ?>"><?php echo $btn_banner['title']; ?> <span
						aria-hidden="true">→</span></a>
			</div>
		</section>

	</div><!-- #contenido -->
	<?php
endwhile; // End of the loop.
?>
</main><!-- #primary -->

<?php
get_footer();
