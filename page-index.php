<?php
/**
 * Template Name: inicio
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

/**Define funciones auxiliares para leer campos de ACF de forma segura en la plantilla: un `get_field()`
 *  de respaldo por si el plugin no está activo (repetido dos veces, una sobra), y cuatro helpers que 
 * devuelven ya escapados un texto (`$t`), un enlace con URL y título (`$lk`), y la URL (`$src`) y el 
 * texto alternativo (`$alt`) de una imagen, con valores vacíos si el campo no existe. */

if (!function_exists('get_field')) {
	function get_field()
	{
		return '';
	}
}
?>
<?php

if (!function_exists('get_field')) {
	function get_field()
	{
		return '';
	}
}

$t = function ($campo) {
	return esc_html((string) get_field($campo));
};

// campo ACF tipo "Enlace", devuelve url y título.
$lk = function ($campo) {
	$l = get_field($campo);
	return is_array($l)
		? array('url' => esc_url($l['url']), 'title' => esc_html($l['title']))
		: array('url' => '#', 'title' => '');
};

//
$src = function ($img) {
	return is_array($img) ? esc_url($img['url']) : '';
};
$alt = function ($img) {
	return is_array($img) ? esc_attr($img['alt']) : '';
};
?>
<main id="primary" class="site-main">
	<?php
	while (have_posts()):
		the_post();

		$diapositivas = get_field('hero_diapositivas') ?: array();
		$total = count($diapositivas);
		$btn_hero_1 = $lk('hero_boton_1');
		$btn_hero_2 = $lk('hero_boton_2');
		?>
		<div id="contenido">

			<!-- 1. HERO DE INICIO -->
			<section class="hero-inicio" aria-labelledby="titulo-inicio">
				<div class="contenedor-amplio">
					<div class="row align-items-center">
						<div class="col-lg-6 hero-inicio-texto">
							<h1 id="titulo-inicio"><?php the_title(); ?></h1>
							<p><?php echo $t('hero_texto'); ?></p>
							<div class="hero-inicio-acciones">
								<a class="btn boton boton-secundario"
									href="<?php echo $btn_hero_1['url']; ?>"><?php echo $btn_hero_1['title']; ?> <span
										class="bi bi-arrow-right" aria-hidden="true"></span></a>
								<a class="btn boton boton-primario"
									href="<?php echo $btn_hero_2['url']; ?>"><?php echo $btn_hero_2['title']; ?> <span
										class="bi bi-arrow-right" aria-hidden="true"></span></a>
							</div>
						</div>
						<div class="col-lg-6 hero-inicio-carrusel-contenedor">
							<?php if ($total): ?>
								<div id="carrusel-inicio" class="hero-inicio-carrusel" role="region"
									aria-roledescription="carrusel" aria-label="Galería de inicio">
									<div class="hero-inicio-pista">
										<?php foreach ($diapositivas as $i => $d): ?>
											<div class="hero-inicio-diapositiva" role="group" aria-roledescription="diapositiva"
												aria-label="<?php echo esc_attr(($i + 1) . ' de ' . $total); ?>">
												<img src="<?php echo $src($d['imagen']); ?>" alt="<?php echo $alt($d['imagen']); ?>"
													loading="<?php echo 0 === $i ? 'eager' : 'lazy'; ?>" decoding="async">
											</div>
										<?php endforeach; ?>
									</div>
									<div class="hero-inicio-controles">
										<button class="hero-inicio-flecha hero-inicio-flecha-anterior" type="button"
											aria-label="Imagen anterior"><span class="bi bi-arrow-left"
												aria-hidden="true"></span></button>
										<div class="hero-inicio-posicion" aria-live="polite">
											<div class="hero-inicio-puntos" aria-hidden="true">
												<?php foreach ($diapositivas as $i => $d): ?>
													<span<?php echo 0 === $i ? ' class="esta-activo"' : ''; ?>></span>
													<?php endforeach; ?>
											</div>
											<span class="hero-inicio-contador"><?php echo esc_html('1 de ' . $total); ?></span>
										</div>
										<button class="hero-inicio-flecha hero-inicio-flecha-siguiente" type="button"
											aria-label="Imagen siguiente"><span class="bi bi-arrow-right"
												aria-hidden="true"></span></button>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</section>

			<!-- 2. NUESTRO COMPROMISO -->
			<?php
			$compromisos = get_field('compromisos') ?: array();
			$filas_comp = array(
				array('clase' => 'row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4', 'items' => array_slice($compromisos, 0, 3)),
				array('clase' => 'row row-cols-1 row-cols-md-2 row-cols-lg-2 g-4 m-1', 'items' => array_slice($compromisos, 3)),
			);
			?>
			<section class="seccion seccion-crema" aria-labelledby="titulo-compromiso">
				<div class="container">
					<header class="encabezado-seccion">
						<h2 id="titulo-compromiso"><?php echo $t('compromiso_titulo'); ?></h2>
					</header>
					<?php foreach ($filas_comp as $fila): ?>
						<?php if ($fila['items']): ?>
							<div class="<?php echo esc_attr($fila['clase']); ?>">
								<?php foreach ($fila['items'] as $c): ?>
									<div class="col">
										<article class="compromiso-tarjeta">
											<img src="<?php echo $src($c['imagen']); ?>" alt="" class="compromiso-imagen"
												aria-hidden="true">
											<div class="compromiso-contenido">
												<h3 class="compromiso-titulo"><?php echo esc_html($c['titulo']); ?></h3>
												<p class="compromiso-texto"><?php echo esc_html($c['texto']); ?></p>
											</div>
										</article>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</section>

			<!-- 3. INFRAESTRUCTURA -->
			<?php
			$infra = get_field('infraestructura_tarjetas') ?: array();
			$btn_infra = $lk('infraestructura_boton');
			?>
			<section class="seccion" aria-labelledby="titulo-infraestructura">
				<div class="container">
					<header class="encabezado-seccion">
						<h2 id="titulo-infraestructura"><?php echo $t('infraestructura_titulo'); ?></h2>
					</header>
					<div class="row justify-content-between">
						<?php foreach ($infra as $i): ?>
							<div class="col-md-4">
								<article class="card tarjeta">
									<img src="<?php echo $src($i['imagen']); ?>" alt="<?php echo $alt($i['imagen']); ?>"
										class="img-fluid card-img-top tarjeta-imagen" loading="lazy" decoding="async">
									<div class="card-body">
										<h3 class="card-title"><?php echo esc_html($i['titulo']); ?></h3>
										<p class="card-text"><?php echo esc_html($i['texto']); ?></p>
									</div>
								</article>
							</div>
						<?php endforeach; ?>
					</div>
					<div class="acciones-seccion">
						<a class="btn boton boton-secundario"
							href="<?php echo $btn_infra['url']; ?>"><?php echo $btn_infra['title']; ?> <span
								class="bi bi-arrow-right" aria-hidden="true"></span></a>
					</div>
				</div>
			</section>

			<!-- 4. ACTIVIDADES -->
			<?php
			$piezas = get_field('actividades_piezas') ?: array();
			$btn_acts = $lk('actividades_boton');
			?>
			<section class="seccion seccion-crema" aria-labelledby="titulo-momentos">
				<div class="container">
					<header class="encabezado-seccion">
						<h2 id="titulo-momentos"><?php echo $t('actividades_titulo'); ?></h2>
					</header>
					<div class="galeria-actividades">
						<div class="galeria-actividades-texto">
							<h3><?php echo $t('actividades_subtitulo'); ?></h3>
							<p><?php echo $t('actividades_texto'); ?></p>
						</div>

						<?php foreach ($piezas as $i => $p): ?>
							<figure
								class="galeria-mosaico-pieza<?php echo 0 === $i ? ' galeria-mosaico-pieza-descripcion' : ''; ?>"
								data-rotulo="<?php echo esc_attr($p['rotulo']); ?>" tabindex="0">
								<img src="<?php echo $src($p['imagen']); ?>" alt="<?php echo $alt($p['imagen']); ?>"
									class="img-fluid" loading="lazy" decoding="async">
								<figcaption class="galeria-mosaico-pie"><?php echo esc_html($p['descripcion']); ?>
								</figcaption>
							</figure>
						<?php endforeach; ?>
					</div>

					<div class="acciones-seccion">
						<a class="btn boton boton-secundario"
							href="<?php echo $btn_acts['url']; ?>"><?php echo $btn_acts['title']; ?> <span
								class="bi bi-arrow-right" aria-hidden="true"></span></a>
					</div>
				</div>
			</section>

			<!-- 5. CAPELLANÍA -->
			<?php
			$btn_cap = $lk('capellania_boton');
			$santo_img = get_field('santo_imagen');
			$santo_fecha = get_field('santo_fecha'); // Selector de fecha, formato de retorno Y-m-d.
			?>
			<section class="seccion capellania-inicio" aria-labelledby="titulo-capellania">
				<div class="container">
					<header class="encabezado-seccion">
						<h2 id="titulo-capellania"><?php echo $t('capellania_titulo'); ?></h2>
						<p><?php echo $t('capellania_texto'); ?></p>
					</header>

					<div class="row g-4 align-items-stretch">

						<!-- 7 columnas: Últimas actividades (entradas de la categoría "capellania") -->
						<div class="col-12 col-lg-7">
							<div class="capellania-publicaciones">
								<h3 class="capellania-publicaciones-titulo">
									<?php echo $t('capellania_publicaciones_titulo'); ?>
								</h3>

								<?php
								$capellania_query = new WP_Query(
									array(
										'post_type' => 'post',
										'category_name' => 'capellania',
										'posts_per_page' => 3,
										'ignore_sticky_posts' => true,
									)
								);

								if ($capellania_query->have_posts()):
									while ($capellania_query->have_posts()):
										$capellania_query->the_post();
										$detalle_id = 'detalle-capellania-' . get_the_ID();
										?>
										<article class="publicacion" data-publicacion>
											<time class="publicacion-fecha"
												datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"><strong><?php echo esc_html(get_the_date('d')); ?></strong><?php echo esc_html(date_i18n('M. Y', get_post_timestamp())); ?></time>
											<div>
												<h4 class="publicacion-titulo"><?php the_title(); ?></h4>
												<p class="publicacion-extracto"><?php echo esc_html(get_the_excerpt()); ?></p>
												<div class="publicacion-detalle collapse" id="<?php echo esc_attr($detalle_id); ?>">
													<?php the_content(); ?>
												</div>
											</div>
											<button class="publicacion-control" type="button" data-bs-toggle="collapse"
												data-bs-target="#<?php echo esc_attr($detalle_id); ?>" aria-expanded="false"
												aria-controls="<?php echo esc_attr($detalle_id); ?>">
												<span class="publicacion-control-texto">Ver más</span>
												<span class="bi bi-arrow-down" aria-hidden="true"></span>
											</button>
										</article>
										<?php
									endwhile;
									wp_reset_postdata();
								endif;
								?>
							</div>
						</div>

						<!-- 5 columnas: Santo del Día -->
						<div class="col-12 col-lg-5">
							<article class="card tarjeta tarjeta-santo-dia" aria-labelledby="titulo-santo-dia"
								data-santo-dia>
								<header class="santo-dia-cabecera">
									<p class="santo-dia-etiqueta"><?php echo $t('santo_etiqueta'); ?></p>
									<h3 class="santo-dia-nombre" id="titulo-santo-dia" data-santo-nombre>
										<?php echo $t('santo_nombre'); ?>
									</h3>
								</header>
								<figure class="santo-dia-imagen">
									<img src="<?php echo $src($santo_img); ?>" alt="<?php echo $alt($santo_img); ?>"
										loading="lazy" decoding="async" data-santo-imagen>
								</figure>
								<div class="santo-dia-contenido">
									<p class="santo-dia-fecha">
										<span class="bi bi-calendar3" aria-hidden="true"></span>
										<time datetime="<?php echo esc_attr($santo_fecha); ?>"
											data-santo-fecha><?php echo $santo_fecha ? esc_html(date_i18n('j \d\e F', strtotime($santo_fecha))) : ''; ?></time>
									</p>
									<p class="santo-dia-descripcion" data-santo-descripcion>
										<?php echo $t('santo_descripcion'); ?>
									</p>
								</div>
							</article>
						</div>
					</div>

					<div class="acciones-seccion">
						<a class="btn boton boton-secundario"
							href="<?php echo $btn_cap['url']; ?>"><?php echo $btn_cap['title']; ?> <span
								class="bi bi-arrow-right" aria-hidden="true"></span></a>
					</div>
				</div>
			</section>

			<!-- 6. CONTACTO -->
			<?php $mapa = get_field('contacto_mapa'); ?>
			<section class="seccion seccion-crema" aria-label="Información de contacto y formulario">
				<div class="contenedor-contenido">
					<div class="row align-items-stretch">
						<div class="col-lg">
							<div class="bloque-contacto-informacion">
								<h3><?php echo $t('contacto_titulo'); ?></h3>
								<p><?php echo $t('contacto_texto'); ?></p>
								<h4><?php echo $t('contacto_ubicacion_titulo'); ?></h4>
								<p><?php echo $t('contacto_direccion'); ?></p>
								<img class="mapa-referencial" src="<?php echo $src($mapa); ?>"
									alt="<?php echo $alt($mapa); ?>" width="524" height="240">
								<h4><?php echo $t('contacto_consultas_titulo'); ?></h4>
								<p><?php echo $t('contacto_consultas_texto'); ?></p>
							</div>
						</div>

						<div class="col-lg-auto d-none d-lg-block">
							<div class="vr h-100"></div>
						</div>

						<div class="col-lg">
							<form class="formulario-contacto" action="<?php echo esc_url(admin_url('admin-post.php')); ?>"
								method="post">
								<input type="hidden" name="action" value="enviar_contacto">
								<?php wp_nonce_field('enviar_contacto', 'contacto_nonce'); ?>

								<div class="campo-formulario">
									<label class="form-label"
										for="nombre"><?php esc_html_e('Nombre completo', 'tu-tema'); ?></label>
									<input class="form-control" type="text" id="nombre" name="nombre"
										placeholder="<?php esc_attr_e('Tu nombre y apellido', 'tu-tema'); ?>"
										autocomplete="name" required>
								</div>

								<div class="campo-formulario">
									<label class="form-label"
										for="correo"><?php esc_html_e('Correo electrónico', 'tu-tema'); ?></label>
									<input class="form-control" type="email" id="correo" name="correo"
										placeholder="nombre@correo.cl" autocomplete="email" required>
								</div>

								<div class="campo-formulario">
									<label class="form-label"
										for="telefono"><?php esc_html_e('Teléfono de contacto (opcional)', 'tu-tema'); ?></label>
									<input class="form-control" type="tel" id="telefono" name="telefono"
										placeholder="+569 12345678" autocomplete="tel">
								</div>

								<div class="campo-formulario">
									<label class="form-label" for="asunto"><?php esc_html_e('Asunto', 'tu-tema'); ?></label>
									<select class="form-select" id="asunto" name="asunto" required>
										<option value="" selected><?php esc_html_e('Selecciona una opción', 'tu-tema'); ?>
										</option>
										<option value="conocer-hogar"><?php esc_html_e('Conocer el hogar', 'tu-tema'); ?>
										</option>
										<option value="visita"><?php esc_html_e('Consultar por una visita', 'tu-tema'); ?>
										</option>
										<option value="contribuir"><?php esc_html_e('Cómo contribuir', 'tu-tema'); ?>
										</option>
										<option value="otro"><?php esc_html_e('Otro', 'tu-tema'); ?></option>
									</select>
								</div>

								<div class="campo-formulario">
									<label class="form-label"
										for="mensaje"><?php esc_html_e('Tu mensaje', 'tu-tema'); ?></label>
									<textarea class="form-control" id="mensaje" name="mensaje" rows="5" required></textarea>
								</div>

								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="privacidad" name="privacidad"
										required>
									<label class="form-check-label" for="privacidad">
										<?php esc_html_e('Acepto la política de privacidad y el manejo de datos de la fundación.', 'tu-tema'); ?>
									</label>
								</div>

								<div class="d-flex justify-content-center">
									<button class="btn boton boton-primario"
										type="submit"><?php esc_html_e('Enviar mensaje', 'tu-tema'); ?></button>
								</div>
							</form>
						</div>

					</div>
				</div>
			</section>

			<!-- 7. BANNER -->
			<?php $btn_banner = $lk('banner_boton'); ?>
			<section class="banner-contribucion" aria-labelledby="titulo-contribucion">
				<div class="contenedor-contenido">
					<h2 id="titulo-contribucion"><?php echo $t('banner_titulo'); ?></h2>
					<p><?php echo $t('banner_texto'); ?></p>
					<a class="btn boton boton-primario"
						href="<?php echo $btn_banner['url']; ?>"><?php echo $btn_banner['title']; ?> <span
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

