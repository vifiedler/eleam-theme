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