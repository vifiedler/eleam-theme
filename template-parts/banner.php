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