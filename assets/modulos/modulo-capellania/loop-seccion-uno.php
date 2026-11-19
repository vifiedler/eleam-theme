<?php
/** Primera sección de Capellanía: fe, compañía y esperanza. */
defined('ABSPATH') || exit;

$titulo = eleam_interior_texto('titulo_seccion_1_capellania');
$contenido = eleam_interior_campo('contenido_seccion_1_capellania');
?>
<section class="seccion seccion-crema capellania-introduccion" aria-labelledby="titulo-introduccion-capellania">
	<div class="container">
		<div class="encabezado-seccion">
			<h2 id="titulo-introduccion-capellania"><?php echo esc_html($titulo); ?></h2>
			<?php if ($contenido !== ''): ?>
				<div class="capellania-introduccion-texto">
					<?php echo wp_kses_post(wpautop((string) $contenido)); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
