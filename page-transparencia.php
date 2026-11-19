<?php
/**
 * Template Name: Transparencia
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

$arch = function ( $f ) {
	if ( is_array( $f ) && ! empty( $f['url'] ) ) {
		return esc_url( $f['url'] );
	}
	return is_string( $f ) && $f ? esc_url( $f ) : '#';
};

$tarjeta_dir = function ( $m, $extra = '' ) use ( $src, $alt ) {
	?>
	<article class="card tarjeta tarjeta-directorio<?php echo $extra ? ' ' . esc_attr( $extra ) : ''; ?>">
		<img src="<?php echo $src( $m['imagen'] ); ?>" alt="<?php echo $alt( $m['imagen'] ); ?>"
			class="img-fluid card-img-top tarjeta-imagen" loading="lazy" decoding="async">
		<div class="card-body">
			<h3><?php echo esc_html( $m['nombre'] ); ?></h3>
			<p><?php echo esc_html( $m['cargo'] ); ?></p><small class="texto-secundario"><?php echo esc_html( $m['nota'] ); ?></small>
		</div>
	</article>
	<?php
};
?>

<main id="primary" class="site-main">
<?php
while ( have_posts() ) :
	the_post();

	$hero_imagen    = get_field( 'hero_imagen' );
	$navegacion     = get_field( 'navegacion' ) ?: array();
	$documentos     = get_field( 'documentos' ) ?: array();
	$aportes        = get_field( 'aportes_tarjetas' ) ?: array();
	$transferencias = get_field( 'transferencias' ) ?: array();
	$destacado      = get_field( 'directorio_destacado' );
	$miembros       = get_field( 'directorio_miembros' ) ?: array();
	$equipo         = get_field( 'equipo_profesional' ) ?: array();

	$total = 0;
	foreach ( $transferencias as $fila ) {
		$total += (int) str_replace( '.', '', (string) $fila['monto'] );
	}
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

		<!-- NAVEGACIÓN + DOCUMENTOS -->
		<section class="seccion" aria-labelledby="titulo-documentos">
			<h2 class="d-none"><?php echo $t( 'documentos_titulo_oculto' ); ?></h2>
			<div class="container">
				<nav class="transparencia-navegacion" aria-label="<?php echo esc_attr( get_field( 'navegacion_etiqueta' ) ); ?>">
					<?php foreach ( $navegacion as $n ) : ?>
					<a class="btn boton boton-secundario" href="#<?php echo esc_attr( $n['ancla'] ); ?>"><?php echo esc_html( $n['texto'] ); ?></a>
					<?php endforeach; ?>
				</nav>

				<section id="documentos" aria-labelledby="titulo-documentos">
					<header class="encabezado-seccion">
						<h2 id="titulo-documentos"><?php echo $t( 'documentos_titulo' ); ?></h2>
						<p><?php echo $t( 'documentos_texto' ); ?></p>
					</header>
					<?php foreach ( $documentos as $d ) : ?>
						<?php $url_doc = $arch( $d['archivo'] ); ?>
					<article class="documento">
						<div class="documento-texto">
							<h3 class="documento-titulo"><?php echo esc_html( $d['titulo'] ); ?></h3>
							<p><?php echo esc_html( $d['descripcion'] ); ?></p>
						</div>
						<div class="documento-acciones">
							<a href="<?php echo $url_doc; ?>" class="btn boton boton-secundario" target="_blank"><?php esc_html_e( 'Ver PDF', 'eleam' ); ?>
								<span class="bi bi-box-arrow-up-right" aria-hidden="true"></span></a>
							<button type="button" class="btn boton boton-secundario" data-archivo="<?php echo $url_doc; ?>"><?php esc_html_e( 'Descargar', 'eleam' ); ?>
								<span class="bi bi-download" aria-hidden="true"></span></button>
						</div>
					</article>
					<?php endforeach; ?>
				</section>
			</div>
		</section>

		<!-- USO DE APORTES -->
		<section id="aportes" class="seccion seccion-crema transparencia-aportes" aria-labelledby="titulo-aportes">
			<div class="container">
				<header class="encabezado-seccion">
					<h2 id="titulo-aportes"><?php echo $t( 'aportes_titulo' ); ?></h2>
					<p><?php echo $t( 'aportes_texto' ); ?></p>
				</header>
				<div class="row">
					<?php foreach ( $aportes as $a ) : ?>
					<div class="col-md-4">
						<article class="card tarjeta">
							<div class="card-body">
								<h3 class="documento-titulo"><?php echo esc_html( $a['titulo'] ); ?></h3>
								<p><?php echo esc_html( $a['texto'] ); ?></p>
							</div>
						</article>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<!-- TRANSFERENCIAS -->
		<section id="transferencias" class="seccion" aria-labelledby="titulo-transferencias">
			<div class="container">
				<header class="encabezado-seccion">
					<h2 id="titulo-transferencias"><?php echo $t( 'transferencias_titulo' ); ?></h2>
					<p><?php echo $t( 'transferencias_texto' ); ?></p>
				</header>
				<div class="table-responsive">
					<table class="tabla-transferencias">
						<caption class="visually-hidden"><?php echo $t( 'transferencias_caption' ); ?></caption>
						<thead>
							<tr>
								<th scope="col"><?php esc_html_e( 'Código Proyecto', 'eleam' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Programa', 'eleam' ); ?></th>
								<th scope="col"><?php esc_html_e( 'N.º Transferencia', 'eleam' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Fecha', 'eleam' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Monto Transferencia', 'eleam' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Trimestre', 'eleam' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Estado', 'eleam' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $transferencias as $f ) : ?>
							<tr>
								<td><?php echo esc_html( $f['codigo'] ); ?></td>
								<td><?php echo esc_html( $f['programa'] ); ?></td>
								<td><?php echo esc_html( $f['numero'] ); ?></td>
								<td><?php echo esc_html( $f['fecha'] ); ?></td>
								<td><?php echo esc_html( $f['monto'] ); ?></td>
								<td><?php echo esc_html( $f['trimestre'] ); ?></td>
								<td><?php echo esc_html( $f['estado'] ); ?></td>
							</tr>
							<?php endforeach; ?>
							<?php if ( $total ) : ?>
							<tr>
								<th scope="row" colspan="4"></th>
								<th scope="row"><?php echo esc_html( number_format( $total, 0, ',', '.' ) ); ?></th>
								<th scope="row" colspan="2"></th>
							</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
				<button type="button" class="btn boton boton-secundario transparencia-descarga" data-archivo="<?php echo $arch( get_field( 'transferencias_archivo' ) ); ?>">
					<?php esc_html_e( 'Descargar registro', 'eleam' ); ?> <span class="bi bi-download" aria-hidden="true"></span>
				</button>
			</div>
		</section>

		<!-- DIRECTORIO -->
		<section id="directorio" class="seccion" aria-labelledby="titulo-directorio">
			<div class="container">
				<header class="encabezado-seccion">
					<h2 id="titulo-directorio"><?php echo $t( 'directorio_titulo' ); ?></h2>
					<p><?php echo $t( 'directorio_texto' ); ?></p>
				</header>

				<?php if ( is_array( $destacado ) ) : ?>
				<div class="row justify-content-center">
					<div class="col-md-6 col-lg-5">
						<?php $tarjeta_dir( $destacado, 'tarjeta-directorio-destacada' ); ?>
					</div>
				</div>
				<?php endif; ?>

				<div class="row justify-content-center mt-4">
					<?php foreach ( $miembros as $m ) : ?>
					<div class="col-sm-6 col-lg-3">
						<?php $tarjeta_dir( $m ); ?>
					</div>
					<?php endforeach; ?>
				</div>

				<header class="encabezado-seccion mt-5">
					<h3><?php echo $t( 'equipo_titulo' ); ?></h3>
					<p><?php echo $t( 'equipo_texto' ); ?></p>
				</header>
				<div class="row justify-content-center">
					<?php foreach ( $equipo as $m ) : ?>
					<div class="col-sm-6 col-lg-3">
						<?php $tarjeta_dir( $m ); ?>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

	</div><!-- #contenido -->
	<?php
endwhile; // End of the loop.
?>
</main><!-- #primary -->

<?php
get_footer();
