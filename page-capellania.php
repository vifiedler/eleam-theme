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

		<!-- GALERÍA -->
		<section class="seccion" aria-labelledby="titulo-galeria">
			<?php include get_template_directory() . '/assets/modulos/modulo-capellania/loop-modulo-capellania.php'; ?>
		</section>

		<!-- CALENDARIO LITÚRGICO: ENCABEZADO -->
		<section class="seccion seccion-crema" aria-labelledby="titulo-calendario-liturgico">
			<div class="container">
				<div class="encabezado-seccion">
					<h2 id="titulo-calendario-liturgico"><?php echo $t( 'calendario_titulo' ); ?></h2>
					<p class="text-center"><?php echo $t( 'calendario_texto' ); ?></p>
				</div>
			</div>
		</section>

		<!-- CALENDARIO LITÚRGICO: HITOS -->
		<section class="calendario-liturgico seccion-crema pb-5" role="group" aria-label="<?php echo esc_attr( get_field( 'calendario_etiqueta' ) ); ?>">
			<div class="calendario-liturgico-linea" aria-hidden="true"></div>
			<div class="container calendario-liturgico-pista">
				<?php foreach ( $hitos as $hito ) : ?>
					<?php
					$fecha       = $hito['fecha']; // Selector de fecha, retorno Y-m-d.
					$fecha_texto = $hito['fecha_texto'] ?: ( $fecha ? date_i18n( 'j \d\e F', strtotime( $fecha ) ) : '' );
					?>
				<article class="calendario-liturgico-hito">
					<div class="calendario-liturgico-tarjeta">
						<h3><?php echo esc_html( $hito['nombre'] ); ?></h3>
					</div>
					<time datetime="<?php echo esc_attr( $fecha ); ?>"><?php echo esc_html( $fecha_texto ); ?></time>
				</article>
				<?php endforeach; ?>
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
				<button type="button" class="calendario-liturgico-control" data-calendario-accion="pausar"
					aria-label="Pausar calendario">
					<i class="bi bi-pause-fill" aria-hidden="true"></i>
				</button>
				<button type="button" class="calendario-liturgico-control" data-calendario-accion="siguiente"
					aria-label="Siguiente hito">
					<i class="bi bi-chevron-right" aria-hidden="true"></i>
				</button>
			</div>
		</section>

		<!-- ACTIVIDADES LITÚRGICAS  -->
		<section class="seccion" aria-labelledby="titulo-publicaciones">
			<div class="container">
				<header class="encabezado-seccion">
					<h2 id="titulo-publicaciones"><?php echo $t( 'publicaciones_titulo' ); ?></h2>
					<p class="text-center"><?php echo $t( 'publicaciones_texto' ); ?></p>
				</header>

				<?php
				$capellania_query = new WP_Query(
					array(
						'post_type'           => 'post',
						'category_name'       => 'capellania',
						'posts_per_page'      => 6,
						'ignore_sticky_posts' => true,
					)
				);

				if ( $capellania_query->have_posts() ) :
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
								<span class="publicacion-control-texto"><?php esc_html_e( 'Ver más', 'eleam' ); ?></span>
								<span class="bi bi-arrow-down" aria-hidden="true"></span>
							</button>
						</article>
						<?php
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>
		</section>

	</div><!-- #contenido -->
	<?php
endwhile; // End of the loop.
?>
</main><!-- #primary -->

<?php
get_footer();
