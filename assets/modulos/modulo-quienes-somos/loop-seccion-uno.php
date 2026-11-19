<?php
/** Primera sección de ¿Quiénes somos?. */
defined('ABSPATH') || exit;

$titulo = eleam_interior_texto('titulo_seccion_uno');
$contenido = eleam_interior_texto('contenido_seccion_uno');
?>
<section class="seccion-crema py-5" aria-labelledby="titulo-definen">
	<div class="container">
		<header class="encabezado-seccion">
			<h2 id="titulo-definen"><?php echo esc_html($titulo); ?></h2>
		</header>
		<?php if ($contenido !== ''): ?>
			<p class="text-center"><?php echo esc_html($contenido); ?></p>
		<?php endif; ?>
	</div>
</section>
