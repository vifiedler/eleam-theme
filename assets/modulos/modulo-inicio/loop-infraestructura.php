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