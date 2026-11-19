<?php
/**
 * Template Name: Nosotros
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

/**Define helpers para mostrar campos de ACF de forma segura en la plantilla:
 *  un get_field() vacío de respaldo si falta el plugin, y funciones que devuelven 
 * ya escapados un texto ($t), un texto con saltos de línea ($br), un texto en párrafos
 *  ($ps), un enlace con URL y título ($lk), y la URL ($src) y el alt ($alt) de una imagen. */


if ( ! function_exists( 'get_field' ) ) {
	function get_field() {
		return '';
	}
}
$t = function ( $campo ) {
	return esc_html( (string) get_field( $campo ) );
};
$br = function ( $texto ) {
	return nl2br( esc_html( (string) $texto ) );
};

$ps = function ( $texto ) {
	return wpautop( esc_html( (string) $texto ) );
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

	$tabs         = get_field( 'valores_tabs' ) ?: array();
	$directivos   = get_field( 'directivos' ) ?: array();
	$clinico      = get_field( 'clinico_tarjetas' ) ?: array();
	?>
	<div id="contenido">

		<?php get_template_part( 'assets/modulos/modulo-quienes-somos/loop-hero' ); ?>

		<?php get_template_part( 'assets/modulos/modulo-quienes-somos/loop-seccion-uno' ); ?>

		<!-- NUESTROS VALORES-->
					<?php include get_template_directory() . '/assets/modulos/modulo-quienes-somos/loop-modulo-quienes-somos.php'; ?>
		<?php get_template_part( 'assets/modulos/modulo-comun/loop-banner' ); ?>

	</div>
	<?php
endwhile; 
?>
</main><!-- #primary -->

<?php
get_footer();