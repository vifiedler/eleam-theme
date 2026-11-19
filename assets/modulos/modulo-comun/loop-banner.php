<?php
/** Banner de contribución compartido por las páginas interiores. */
defined('ABSPATH') || exit;

$titulo = eleam_interior_texto('titulo_banner');
$texto = eleam_interior_texto('texto_banner');
$boton = eleam_interior_enlace('enlace_donacion');

if ($titulo === '' && $texto === '') {
	return;
}
?>
<section class="banner-contribucion" aria-labelledby="titulo-contribucion">
	<div class="contenedor-contenido">
		<?php if ($titulo !== ''): ?>
			<h2 id="titulo-contribucion"><?php echo esc_html($titulo); ?></h2>
		<?php endif; ?>
		<?php if ($texto !== ''): ?>
			<p><?php echo esc_html($texto); ?></p>
		<?php endif; ?>
		<?php eleam_interior_boton($boton); ?>
	</div>
</section>
