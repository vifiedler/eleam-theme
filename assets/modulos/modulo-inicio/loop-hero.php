<?php
$diapositivas = get_field('hero_diapositivas') ?: array();
$total = count($diapositivas);
$btn_hero_1 = $lk('hero_boton_1');
$btn_hero_2 = $lk('hero_boton_2');
?>
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