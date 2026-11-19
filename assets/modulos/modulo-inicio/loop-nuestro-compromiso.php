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