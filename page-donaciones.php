<?php
/**
 * Template Name: Contribuye
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

$valor_activo = function ( $opciones ) {
	foreach ( $opciones as $o ) {
		if ( ! empty( $o['activo'] ) ) {
			return $o['valor'];
		}
	}
	return $opciones ? $opciones[0]['valor'] : '';
};
?>

<main id="primary" class="site-main">
<?php
while ( have_posts() ) :
	the_post();

	$hero_imagen = get_field( 'hero_imagen' );
	$tarjetas    = get_field( 'posible_tarjetas' ) ?: array();
	$futuro_img  = get_field( 'futuro_imagen' );
	$frecuencias = get_field( 'aporte_frecuencias' ) ?: array();
	$montos      = get_field( 'aporte_montos' ) ?: array();
	$btn_banner  = $lk( 'banner_boton' );
	?>
	<div id="contenido">

		<!-- HERO -->
		<section class="hero-interior" aria-labelledby="titulo-contribuye">
			<div class="contenedor-amplio">
				<div class="row">
					<div class="col-md-6 hero-interior-texto">
						<h1 id="titulo-contribuye"><?php the_title(); ?></h1>
						<p><?php echo $t( 'hero_texto' ); ?></p>
					</div>
					<div class="col-md-6">
						<img class="hero-interior-imagen" src="<?php echo $src( $hero_imagen ); ?>"
							alt="<?php echo $alt( $hero_imagen ); ?>" width="720" height="340">
					</div>
				</div>
			</div>
		</section>

		<!-- LO QUE HACEMOS POSIBLE JUNTOS -->
		<section class="seccion seccion-crema" aria-labelledby="titulo-posible">
			<div class="contenedor-contenido">
				<div class="encabezado-seccion">
					<h2 id="titulo-posible"><?php echo $t( 'posible_titulo' ); ?></h2>
				</div>

				<div class="row justify-content-center">
					<?php foreach ( $tarjetas as $c ) : ?>
					<div class="col-md-4">
						<article class="card tarjeta tarjeta-impacto">
							<div class="card-body">
								<h3 class="titulo-tarjeta"><?php echo esc_html( $c['titulo'] ); ?></h3>
								<p class="subtitulo"><?php echo esc_html( $c['subtitulo'] ); ?></p>
							</div>
							<div class="card-body">
								<p><?php echo esc_html( $c['texto'] ); ?></p>
							</div>
						</article>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<!-- FORMULARIO -->
		<section class="seccion seccion-crema pt-0" aria-labelledby="titulo-futuro">
			<div class="contenedor-amplio">
				<div class="encabezado-seccion">
					<h2 id="titulo-futuro"><?php echo $t( 'futuro_titulo' ); ?></h2>
				</div>
				<div class="row align-items-stretch">
					<div class="col-lg">
						<img class="imagen-aporte" src="<?php echo $src( $futuro_img ); ?>"
							alt="<?php echo $alt( $futuro_img ); ?>" width="634" height="870">
					</div>
					<div class="col-lg-auto d-none d-lg-block">
						<div class="vr h-100"></div>
					</div>
					<div class="col-lg">
						<form class="formulario-contacto formulario-aporte" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
							<input type="hidden" name="action" value="enviar_aporte">
							<?php wp_nonce_field( 'enviar_aporte', 'aporte_nonce' ); ?>
							<input type="hidden" name="frecuencia" value="<?php echo esc_attr( $valor_activo( $frecuencias ) ); ?>">
							<input type="hidden" name="monto" value="<?php echo esc_attr( $valor_activo( $montos ) ); ?>">

							<fieldset>
								<legend class="subtitulo"><?php echo $t( 'aporte_leyenda_frecuencia' ); ?></legend>
								<div class="opciones-aporte" data-grupo="frecuencia">
									<?php foreach ( $frecuencias as $f ) : ?>
									<button class="btn boton boton-secundario" type="button" aria-pressed="<?php echo ! empty( $f['activo'] ) ? 'true' : 'false'; ?>"
										data-valor="<?php echo esc_attr( $f['valor'] ); ?>"><?php echo esc_html( $f['texto'] ); ?></button>
									<?php endforeach; ?>
								</div>
							</fieldset>
							<fieldset>
								<legend class="subtitulo"><?php echo $t( 'aporte_leyenda_monto' ); ?></legend>
								<div class="row">
									<div class="opciones-aporte" data-grupo="monto"></div>
									<?php foreach ( $montos as $m ) : ?>
									<div class="col-3">
										<button class="btn boton boton-contorno" type="button" aria-pressed="<?php echo ! empty( $m['activo'] ) ? 'true' : 'false'; ?>"
											data-valor="<?php echo esc_attr( $m['valor'] ); ?>"><?php echo esc_html( $m['texto'] ); ?></button>
									</div>
									<?php endforeach; ?>
								</div>
							</fieldset>
							<fieldset>
								<legend class="subtitulo"><?php echo $t( 'aporte_leyenda_datos' ); ?></legend>
								<div class="campo-formulario mt-3">
									<label class="form-label" for="nombre"><?php esc_html_e( 'Nombre completo', 'eleam' ); ?></label>
									<input class="form-control" type="text" id="nombre" name="nombre" placeholder="<?php esc_attr_e( 'Tu nombre y apellido', 'eleam' ); ?>"
										autocomplete="name" required>
								</div>
								<div class="campo-formulario">
									<label class="form-label" for="correo"><?php esc_html_e( 'Correo electrónico', 'eleam' ); ?></label>
									<input class="form-control" type="email" id="correo" name="correo" placeholder="nombre@correo.cl"
										autocomplete="email" required>
								</div>
								<div class="campo-formulario">
									<label class="form-label" for="telefono"><?php esc_html_e( 'Teléfono de contacto (opcional)', 'eleam' ); ?></label>
									<input class="form-control" type="tel" id="telefono" name="telefono" placeholder="+569 12345678"
										autocomplete="tel">
								</div>
							</fieldset>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="privacidad" name="privacidad" required>
								<label class="form-check-label" for="privacidad">
									<?php esc_html_e( 'Leí la política de privacidad y el manejo de datos de la fundación.', 'eleam' ); ?>
								</label>
							</div>
							<div class="d-flex justify-content-center">
								<button class="btn boton boton-primario" type="submit"><?php esc_html_e( 'Continuar al pago', 'eleam' ); ?> <span
										aria-hidden="true">→</span></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>

		<!-- BANNER -->
		<section class="banner-contribucion" aria-labelledby="titulo-confianza">
			<div class="contenedor-contenido">
				<h2 id="titulo-confianza"><?php echo $t( 'banner_titulo' ); ?></h2>
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
