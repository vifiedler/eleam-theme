<?php
/**
 * Template Name: Capellanía
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
	$piezas      = get_field( 'galeria_piezas' ) ?: array();
	$hitos       = get_field( 'calendario_hitos' ) ?: array();
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
					<div class="col-md-6">
						<img src="<?php echo $src( $hero_imagen ); ?>" alt="<?php echo $alt( $hero_imagen ); ?>"
							class="img-fluid hero-interior-imagen" decoding="async">
					</div>
				</div>
			</div>
		</section>

		<!-- FE, COMPAÑÍA Y ESPERANZA -->
		<section class="seccion seccion-crema">
			<div class="container">
				<div class="encabezado-seccion">
					<h2><?php echo $t( 'fe_titulo' ); ?></h2>
					<?php echo $ps( get_field( 'fe_texto' ) ); ?>
				</div>
			</div>
		</section>

			<?php include get_template_directory() . '/assets/modulos/modulo-capellania/loop-modulo-capellania.php'; ?>

	</div><!-- #contenido -->
	<?php
endwhile; // End of the loop.
?>
</main><!-- #primary -->

<?php
get_footer();
