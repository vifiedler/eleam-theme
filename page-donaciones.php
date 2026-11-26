<?php
/**
 * Template Name: Contribuye
 *
 * Página Contribuye (ID 30). Replica donaciones.html.
 *
 * Grupos SCF:
 * - "ELEAM | Hero de páginas interiores": titulo_pagina, bajada_texto, imagen_pagina.
 * - "ELEAM | Contribuye":
 *   - titulo_impacto_donaciones, tarjetas_impacto (titulo_tarjeta_impacto, subtitulo_tarjeta_impacto, descripcion_tarjeta_impacto)
 *   - titulo_formulario_donaciones, imagen_lateral_donaciones
 *   - montos_donacion (monto_sugerido_donacion, etiqueta_monto_donacion)
 *   - textos_formulario_donacion (grupo con los textos del formulario)
 *   - banner_confianza_donaciones (titulo_banner_confianza, texto_banner_confianza, enlace_transparencia_donaciones)
 *
 * @package eleam-theme
 */

get_header();

if ( ! function_exists( 'get_field' ) ) {
	function get_field() {
		return '';
	}
}

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

	// Hero.
	$hero_titulo = get_field( 'titulo_pagina' ) ?: get_the_title();
	$hero_imagen = get_field( 'imagen_pagina' );

	// Impacto.
	$tarjetas = get_field( 'tarjetas_impacto' ) ?: array();

	// Formulario.
	$imagen_lateral = get_field( 'imagen_lateral_donaciones' );
	$montos         = get_field( 'montos_donacion' ) ?: array();
	// Textos del formulario: los campos vacíos en SCF usan el texto por defecto.
	$textos_scf = array_filter(
		get_field( 'textos_formulario_donacion' ) ?: array(),
		function ( $valor ) {
			return '' !== $valor && null !== $valor;
		}
	);
	$textos     = array_merge(
		array(
			'titulo_frecuencia'           => 'Escoge tu forma de aportar',
			'texto_donacion_mensual'      => 'Mensual',
			'texto_donacion_unica'        => 'Una vez',
			'titulo_montos'               => 'Escoge el monto',
			'texto_otro_monto'            => 'Otro monto',
			'titulo_datos_donante'        => 'Datos personales',
			'etiqueta_nombre_donante'     => 'Nombre completo',
			'placeholder_nombre_donante'  => '',
			'etiqueta_correo_donante'     => 'Correo electrónico',
			'placeholder_correo_donante'  => '',
			'etiqueta_telefono_donante'   => 'Teléfono de contacto (opcional)',
			'placeholder_telefono_donante' => '',
			'texto_boton_pago'            => 'Continuar al pago',
			'texto_aceptacion_donacion'   => 'Leí la política de privacidad y el manejo de datos de la fundación.',
			'pagina_politica_donaciones'  => '',
		),
		$textos_scf
	);

	// Monto seleccionado por defecto: el segundo (como en la maqueta) o el primero.
	$monto_inicial = isset( $montos[1] ) ? $montos[1]['monto_sugerido_donacion'] : ( $montos[0]['monto_sugerido_donacion'] ?? '' );

	// Banner de confianza.
	$banner        = get_field( 'banner_confianza_donaciones' ) ?: array();
	$banner_enlace = $banner['enlace_transparencia_donaciones'] ?? null;
	?>
	<div id="contenido">

		<!-- HERO -->
		<section class="hero-interior" aria-labelledby="titulo-contribuye">
			<div class="contenedor-amplio">
				<div class="row">
					<div class="col-md-6 hero-interior-texto">
						<h1 id="titulo-contribuye"><?php echo esc_html( $hero_titulo ); ?></h1>
						<p><?php echo esc_html( get_field( 'bajada_texto' ) ); ?></p>
					</div>
					<?php if ( $hero_imagen ) : ?>
					<div class="col-md-6">
						<img class="hero-interior-imagen" src="<?php echo $src( $hero_imagen ); ?>"
							alt="<?php echo $alt( $hero_imagen ); ?>" width="720" height="340">
					</div>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<!-- LO QUE HACEMOS POSIBLE JUNTOS -->
		<?php if ( $tarjetas ) : ?>
		<section class="seccion seccion-crema" aria-labelledby="titulo-posible">
			<div class="contenedor-contenido">
				<div class="encabezado-seccion">
					<h2 id="titulo-posible"><?php echo esc_html( get_field( 'titulo_impacto_donaciones' ) ); ?></h2>
				</div>

				<div class="row justify-content-center">
					<?php foreach ( $tarjetas as $tarjeta ) : ?>
					<div class="col-md-4">
						<article class="card tarjeta tarjeta-impacto">
							<div class="card-body">
								<h3 class="titulo-tarjeta"><?php echo esc_html( $tarjeta['titulo_tarjeta_impacto'] ); ?></h3>
								<p class="subtitulo"><?php echo esc_html( $tarjeta['subtitulo_tarjeta_impacto'] ); ?></p>
							</div>
							<div class="card-body">
								<p><?php echo esc_html( $tarjeta['descripcion_tarjeta_impacto'] ); ?></p>
							</div>
						</article>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php endif; ?>

		<!-- FORTALECE EL FUTURO: FORMULARIO -->
		<section class="seccion seccion-crema pt-0" aria-labelledby="titulo-futuro">
			<div class="contenedor-amplio">
				<div class="encabezado-seccion">
					<h2 id="titulo-futuro"><?php echo esc_html( get_field( 'titulo_formulario_donaciones' ) ); ?></h2>
				</div>
				<div class="row align-items-stretch">
					<?php if ( $imagen_lateral ) : ?>
					<div class="col-lg">
						<img class="imagen-aporte" src="<?php echo $src( $imagen_lateral ); ?>"
							alt="<?php echo $alt( $imagen_lateral ); ?>" width="634" height="870" loading="lazy">
					</div>
					<div class="col-lg-auto d-none d-lg-block">
						<div class="vr h-100"></div>
					</div>
					<?php endif; ?>
					<div class="col-lg">
						<?php // Pendiente: conectar con la pasarela de pago. Por ahora el formulario no envía datos. ?>
						<form class="formulario-contacto formulario-aporte" action="#" method="post">
							<input type="hidden" name="frecuencia" value="una-vez">
							<input type="hidden" name="monto" value="<?php echo esc_attr( $monto_inicial ); ?>">

							<fieldset>
								<legend class="subtitulo"><?php echo esc_html( $textos['titulo_frecuencia'] ); ?></legend>
								<div class="opciones-aporte" data-grupo="frecuencia">
									<button class="btn boton boton-secundario" type="button" aria-pressed="false"
										data-valor="mensual"><?php echo esc_html( $textos['texto_donacion_mensual'] ); ?></button>
									<button class="btn boton boton-secundario" type="button" aria-pressed="true"
										data-valor="una-vez"><?php echo esc_html( $textos['texto_donacion_unica'] ); ?></button>
								</div>
							</fieldset>

							<fieldset>
								<legend class="subtitulo"><?php echo esc_html( $textos['titulo_montos'] ); ?></legend>
								<div class="row mt-3" data-grupo="monto">
									<?php foreach ( $montos as $monto ) : ?>
										<?php
										$valor    = (string) $monto['monto_sugerido_donacion'];
										$etiqueta = $monto['etiqueta_monto_donacion'] ?: '$' . number_format( (int) $valor, 0, ',', '.' );
										?>
									<div class="col-3">
										<button class="btn boton boton-contorno" type="button" aria-pressed="<?php echo (string) $monto_inicial === $valor ? 'true' : 'false'; ?>"
											data-valor="<?php echo esc_attr( $valor ); ?>"><?php echo esc_html( $etiqueta ); ?></button>
									</div>
									<?php endforeach; ?>
									<div class="col-3">
										<button class="btn boton boton-contorno" type="button" aria-pressed="false"
											data-valor="otro"><?php echo esc_html( $textos['texto_otro_monto'] ); ?></button>
									</div>
								</div>
								<div class="campo-formulario mt-3" id="campo-otro-monto" hidden>
									<label class="form-label" for="otro-monto"><?php esc_html_e( 'Monto en pesos (CLP)', 'eleam' ); ?></label>
									<input class="form-control" type="number" id="otro-monto" name="otro_monto" min="1000" step="1000" inputmode="numeric">
								</div>
							</fieldset>

							<fieldset>
								<legend class="subtitulo"><?php echo esc_html( $textos['titulo_datos_donante'] ); ?></legend>
								<div class="campo-formulario mt-3">
									<label class="form-label" for="nombre"><?php echo esc_html( $textos['etiqueta_nombre_donante'] ); ?></label>
									<input class="form-control" type="text" id="nombre" name="nombre" placeholder="<?php echo esc_attr( $textos['placeholder_nombre_donante'] ); ?>"
										autocomplete="name" required>
								</div>
								<div class="campo-formulario">
									<label class="form-label" for="correo"><?php echo esc_html( $textos['etiqueta_correo_donante'] ); ?></label>
									<input class="form-control" type="email" id="correo" name="correo" placeholder="<?php echo esc_attr( $textos['placeholder_correo_donante'] ); ?>"
										autocomplete="email" required>
								</div>
								<div class="campo-formulario">
									<label class="form-label" for="telefono"><?php echo esc_html( $textos['etiqueta_telefono_donante'] ); ?></label>
									<input class="form-control" type="tel" id="telefono" name="telefono" placeholder="<?php echo esc_attr( $textos['placeholder_telefono_donante'] ); ?>"
										autocomplete="tel">
								</div>
							</fieldset>

							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="privacidad" name="privacidad" required>
								<label class="form-check-label" for="privacidad">
									<?php if ( $textos['pagina_politica_donaciones'] ) : ?>
										<a href="<?php echo esc_url( $textos['pagina_politica_donaciones'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $textos['texto_aceptacion_donacion'] ); ?></a>
									<?php else : ?>
										<?php echo esc_html( $textos['texto_aceptacion_donacion'] ); ?>
									<?php endif; ?>
								</label>
							</div>
							<div class="d-flex justify-content-center">
								<button class="btn boton boton-primario" type="submit"><?php echo esc_html( $textos['texto_boton_pago'] ); ?> <span
										aria-hidden="true">→</span></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>

		<!-- BANNER DE CONFIANZA -->
		<?php if ( ! empty( $banner['titulo_banner_confianza'] ) ) : ?>
		<section class="banner-contribucion" aria-labelledby="titulo-confianza">
			<div class="contenedor-contenido">
				<h2 id="titulo-confianza"><?php echo esc_html( $banner['titulo_banner_confianza'] ); ?></h2>
				<p><?php echo esc_html( $banner['texto_banner_confianza'] ); ?></p>
				<?php if ( is_array( $banner_enlace ) && ! empty( $banner_enlace['url'] ) ) : ?>
				<a class="btn boton boton-primario" href="<?php echo esc_url( $banner_enlace['url'] ); ?>"<?php echo ! empty( $banner_enlace['target'] ) ? ' target="' . esc_attr( $banner_enlace['target'] ) . '"' : ''; ?>><?php echo esc_html( $banner_enlace['title'] ); ?> <span
						aria-hidden="true">→</span></a>
				<?php endif; ?>
			</div>
		</section>
		<?php endif; ?>

	</div><!-- #contenido -->
	<?php
endwhile; // End of the loop.
?>
</main><!-- #primary -->

<?php
get_footer();