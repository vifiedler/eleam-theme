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
		<section class="seccion seccion-crema" aria-label="<?php echo esc_attr( get_field( 'contacto_etiqueta' ) ); ?>">
			<div class="contenedor-contenido">
				<div class="row align-items-stretch">
					<div class="col-lg">
						<div class="bloque-contacto-informacion">
							<h2 class="d-none"><?php echo $t( 'contacto_titulo_oculto' ); ?></h2>
							<h3><?php echo $t( 'contacto_titulo' ); ?></h3>
							<p><?php echo $t( 'contacto_texto' ); ?></p>
							<h4><?php echo $t( 'contacto_ubicacion_titulo' ); ?></h4>
							<p><?php echo $t( 'contacto_direccion' ); ?></p>
							<img class="mapa-referencial" src="<?php echo $src( $mapa ); ?>"
								alt="<?php echo $alt( $mapa ); ?>"
								width="524" height="240">
							<h4><?php echo $t( 'contacto_consultas_titulo' ); ?></h4>
							<p><?php echo $t( 'contacto_consultas_texto' ); ?></p>
						</div>
					</div>

					<div class="col-lg-auto d-none d-lg-block">
						<div class="vr h-100"></div>
					</div>

					<div class="col-lg">
						<form class="formulario-contacto" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
							<input type="hidden" name="action" value="enviar_contacto">
							<?php wp_nonce_field( 'enviar_contacto', 'contacto_nonce' ); ?>

							<div class="campo-formulario">
								<label class="form-label" for="nombre"><?php esc_html_e( 'Nombre completo', 'eleam' ); ?></label>
								<input class="form-control" type="text" id="nombre" name="nombre"
									placeholder="<?php esc_attr_e( 'Tu nombre y apellido', 'eleam' ); ?>" autocomplete="name" required>
							</div>

							<div class="campo-formulario">
								<label class="form-label" for="correo"><?php esc_html_e( 'Correo electrónico', 'eleam' ); ?></label>
								<input class="form-control" type="email" id="correo" name="correo"
									placeholder="nombre@correo.cl" autocomplete="email" required>
							</div>

							<div class="campo-formulario">
								<label class="form-label" for="telefono"><?php esc_html_e( 'Teléfono de contacto (opcional)', 'eleam' ); ?></label>
								<input class="form-control" type="tel" id="telefono" name="telefono"
									placeholder="+569 12345678" autocomplete="tel">
							</div>

							<div class="campo-formulario">
								<label class="form-label" for="asunto"><?php esc_html_e( 'Asunto', 'eleam' ); ?></label>
								<select class="form-select" id="asunto" name="asunto" required>
									<option value="" selected><?php esc_html_e( 'Selecciona una opción', 'eleam' ); ?></option>
									<option value="conocer-hogar"><?php esc_html_e( 'Conocer el hogar', 'eleam' ); ?></option>
									<option value="visita"><?php esc_html_e( 'Consultar por una visita', 'eleam' ); ?></option>
									<option value="contribuir"><?php esc_html_e( 'Cómo contribuir', 'eleam' ); ?></option>
									<option value="otro"><?php esc_html_e( 'Otro', 'eleam' ); ?></option>
								</select>
							</div>

							<div class="campo-formulario">
								<label class="form-label" for="mensaje"><?php esc_html_e( 'Tu mensaje', 'eleam' ); ?></label>
								<textarea class="form-control" id="mensaje" name="mensaje" rows="5" required></textarea>
							</div>

							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="privacidad" name="privacidad"
									required>
								<label class="form-check-label" for="privacidad">
									<?php esc_html_e( 'Acepto la política de privacidad y el manejo de datos de la fundación.', 'eleam' ); ?>
								</label>
							</div>

							<div class="d-flex justify-content-center">
								<button class="btn boton boton-primario" type="submit"><?php esc_html_e( 'Enviar mensaje', 'eleam' ); ?></button>
							</div>
						</form>
					</div>

				</div>
			</div>
		</section>

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
