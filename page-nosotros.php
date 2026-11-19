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

	$hero_imagen  = get_field( 'hero_imagen' );
	$tabs         = get_field( 'valores_tabs' ) ?: array();
	$directivos   = get_field( 'directivos' ) ?: array();
	$clinico      = get_field( 'clinico_tarjetas' ) ?: array();
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
						<img src="<?php echo $src( $hero_imagen ); ?>" alt="<?php echo $alt( $hero_imagen ); ?>" class="img-fluid hero-interior-imagen">
					</div>
				</div>
			</div>
		</section>

		<!-- QUÉ NOS DEFINE -->
		<section class="seccion-crema py-5" aria-labelledby="titulo-definen">
			<div class="container">
				<header class="encabezado-seccion">
					<h2 id="titulo-definen"><?php echo $t( 'definen_titulo' ); ?></h2>
				</header>
				<p class="text-center"><?php echo $t( 'definen_texto' ); ?></p>
			</div>
		</section>

		<!-- NUESTROS VALORES-->
		<?php if ( $tabs ) : ?>
		<section class="seccion" aria-labelledby="titulo-valores">
			<div class="container">
				<header class="encabezado-seccion">
					<h2 id="titulo-valores"><?php echo $t( 'valores_titulo' ); ?></h2>
				</header>

				<div class="nav d-grid talleres-botones" role="tablist" style="grid-template-columns: repeat(<?php echo count( $tabs ); ?>, 1fr);">
					<?php foreach ( $tabs as $i => $tab ) : ?>
						<?php $slug = sanitize_title( $tab['pestana'] ) ?: 'item-' . $i; ?>
					<button type="button" id="tab-<?php echo esc_attr( $slug ); ?>" class="taller-boton<?php echo 0 === $i ? ' active' : ''; ?>" data-bs-toggle="tab" data-bs-target="#panel-<?php echo esc_attr( $slug ); ?>" role="tab" aria-controls="panel-<?php echo esc_attr( $slug ); ?>" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"<?php echo 0 === $i ? '' : ' tabindex="-1"'; ?>><?php echo esc_html( $tab['pestana'] ); ?></button>
					<?php endforeach; ?>
				</div>

				<div class="tab-content">
					<?php foreach ( $tabs as $i => $tab ) : ?>
						<?php $slug = sanitize_title( $tab['pestana'] ) ?: 'item-' . $i; ?>
					<div class="tab-pane fade<?php echo 0 === $i ? ' show active' : ''; ?>" id="panel-<?php echo esc_attr( $slug ); ?>" role="tabpanel" aria-labelledby="tab-<?php echo esc_attr( $slug ); ?>" tabindex="0">
						<div class="d-flex flex-column flex-md-row taller-panel">
							<img src="<?php echo $src( $tab['imagen'] ); ?>" alt="<?php echo $alt( $tab['imagen'] ); ?>" class="col-md-6 img-fluid object-fit-cover">
							<div class="d-flex flex-column taller-contenido col-md-6">
								<h3 class="taller-titulo mt-4 text-center"><?php echo esc_html( $tab['titulo'] ); ?></h3>
								<?php echo $ps( $tab['texto'] ); ?>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php endif; ?>

		<!-- NUESTRO EQUIPO -->
		<section class="seccion" aria-labelledby="titulo-equipo">
			<div class="container">
				<header class="encabezado-seccion">
					<h2 id="titulo-equipo"><?php echo $t( 'equipo_titulo' ); ?></h2>
				</header>

				<h3 class="mb-3"><?php echo $t( 'directivos_titulo' ); ?></h3>
				<div class="row mb-5">
					<?php foreach ( $directivos as $d ) : ?>
					<div class="col-lg-6">
						<article class="card tarjeta tarjeta-horizontal">
							<img src="<?php echo $src( $d['imagen'] ); ?>" alt="<?php echo $alt( $d['imagen'] ); ?>" class="img-fluid card-img-top tarjeta-horizontal-imagen" loading="lazy" decoding="async">
							<div>
								<h3 class="tarjeta-horizontal-titulo"><?php echo esc_html( $d['nombre'] ); ?></h3>
								<div class="card-body">
									<h4><?php echo esc_html( $d['cargo'] ); ?></h4>
									<p><?php echo $br( $d['detalle'] ); ?></p>
								</div>
							</div>
						</article>
					</div>
					<?php endforeach; ?>
				</div>

				<h3 class="mb-3"><?php echo $t( 'clinico_titulo' ); ?></h3>
				<p class="mb-4"><?php echo $t( 'clinico_texto' ); ?></p>
				<div class="row">
					<?php foreach ( $clinico as $c ) : ?>
					<div class="col-md-4">
						<article class="card tarjeta tarjeta-persona">
							<img src="<?php echo $src( $c['imagen'] ); ?>" alt="<?php echo $alt( $c['imagen'] ); ?>" class="img-fluid card-img-top tarjeta-imagen" loading="lazy" decoding="async">
							<div class="card-body">
								<h3><?php echo esc_html( $c['titulo'] ); ?></h3>
								<p class="texto-secundario"><?php echo esc_html( $c['subtitulo'] ); ?></p>
								<p><?php echo esc_html( $c['texto'] ); ?></p>
							</div>
						</article>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<!-- BANNER -->
		<?php $btn_banner = $lk( 'banner_boton' ); ?>
		<section class="banner-contribucion" aria-labelledby="titulo-contribucion">
			<div class="contenedor-contenido">
				<h2 id="titulo-contribucion"><?php echo $t( 'banner_titulo' ); ?></h2>
				<p><?php echo $t( 'banner_texto' ); ?></p>
				<a class="btn boton boton-primario" href="<?php echo $btn_banner['url']; ?>"><?php echo $btn_banner['title']; ?> <span
						aria-hidden="true">→</span></a>
			</div>
		</section>

	</div>
	<?php
endwhile; 
?>
</main><!-- #primary -->

<?php
get_footer();