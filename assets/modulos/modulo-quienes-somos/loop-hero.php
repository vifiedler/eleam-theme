<?php
/** Hero de ¿Quiénes somos?. */
defined('ABSPATH') || exit;

$titulo = eleam_interior_texto('titulo_pagina', false, get_the_title());
$bajada = eleam_interior_texto('bajada_texto');
$imagen = eleam_interior_imagen(
	eleam_interior_campo('imagen_pagina'),
	'img-fluid hero-interior-imagen',
	$titulo,
	'large',
	'eager'
);
?>
<section class="hero-interior" aria-labelledby="titulo-pagina-nosotros">
	<div class="container-fluid contenedor-amplio">
		<div class="row align-items-center">
			<div class="<?php echo $imagen !== '' ? 'col-md-6' : 'col-12'; ?> hero-interior-texto">
				<h1 id="titulo-pagina-nosotros"><?php echo esc_html($titulo); ?></h1>
				<?php if ($bajada !== ''): ?>
					<p><?php echo esc_html($bajada); ?></p>
				<?php endif; ?>
			</div>
			<?php if ($imagen !== ''): ?>
				<div class="col-md-6"><?php echo $imagen; ?></div>
			<?php endif; ?>
		</div>
	</div>
</section>
