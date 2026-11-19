<?php
/** Primera sección de Capellanía: fe, compañía y esperanza. */
defined('ABSPATH') || exit;

$titulo = eleam_interior_texto('titulo_seccion_1_capellania');
$contenido = eleam_interior_campo('contenido_seccion_1_capellania');
?>
<section class="seccion seccion-crema">
	<div class="container">
		<div class="encabezado-seccion">
			<h2><?php echo esc_html($titulo); ?></h2>
			<?php if ($contenido !== ''): ?>
				<?php echo wp_kses_post(wpautop((string) $contenido)); ?>
			<?php endif; ?>
		</div>
	</div>
</section>
