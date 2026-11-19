<?php
$grupos_valores = array(
	'mision'     => 'grupo_mision',
	'vision'     => 'grupo_vision',
	'gobernanza' => 'grupo_gobernanza',
);

$tabs = array();
foreach ( $grupos_valores as $clave => $grupo_campo ) {
	$grupo = function_exists( 'get_field' ) ? get_field( $grupo_campo ) : null;

	if ( ! is_array( $grupo ) || empty( $grupo[ 'titulo_' . $clave ] ) ) {
		continue;
	}

	$tabs[] = array(
		'pestana' => $grupo[ 'titulo_' . $clave ],
		'imagen'  => $grupo[ 'imagen_' . $clave ], null,
		'titulo'  => $grupo[ 'titulo_texto_' . $clave ], '',
		'texto'   => $grupo[ 'texto_' . $clave ], '',
	);
}
?>

<?php if ( $tabs ) : ?>
	<section class="seccion" aria-labelledby="titulo-valores">
		<div class="container">
			<header class="encabezado-seccion">
				<h2 id="titulo-valores"><?php echo esc_html( get_field( 'titulo_seccion_dos' ) ); ?></h2>
			</header>

			<div class="nav d-grid talleres-botones" role="tablist" style="grid-template-columns: repeat(<?php echo count( $tabs ); ?>, 1fr);">
				<?php foreach ( $tabs as $i => $tab ) : ?>
					<?php $slug = sanitize_title( $tab['pestana'] ) ?: 'item-' . $i; ?>
					<button type="button" id="tab-<?php echo esc_attr( $slug ); ?>" class="taller-boton<?php echo 0 === $i ? ' active' : ''; ?>" data-bs-toggle="tab" data-bs-target="#panel-<?php echo esc_attr( $slug ); ?>" role="tab" aria-controls="panel-<?php echo esc_attr( $slug ); ?>" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"<?php echo 0 === $i ? '' : ' tabindex="-1"'; ?>><?php echo esc_html( $tab['pestana'] ); ?></button>
				<?php endforeach; ?>
			</div>

			<div class="tab-content">
				<?php foreach ( $tabs as $i => $tab ) : ?>
					<?php
					$slug   = sanitize_title( $tab['pestana'] ) ?: 'item-' . $i;
					$imagen = $tab['imagen'];
					?>
					<div class="tab-pane fade<?php echo 0 === $i ? ' show active' : ''; ?>" id="panel-<?php echo esc_attr( $slug ); ?>" role="tabpanel" aria-labelledby="tab-<?php echo esc_attr( $slug ); ?>" tabindex="0">
						<div class="d-flex flex-column flex-md-row taller-panel">
							<?php if ( is_array( $imagen ) && ! empty( $imagen['url'] ) ) : ?>
								<img src="<?php echo esc_url( $imagen['url'] ); ?>"
									alt="<?php echo esc_attr( ! empty( $imagen['alt'] ) ? $imagen['alt'] : $tab['titulo'] ); ?>"
									class="col-md-6 img-fluid object-fit-cover"
									loading="lazy" decoding="async">
							<?php endif; ?>
							<div class="d-flex flex-column taller-contenido col-md-6">
								<h3 class="taller-titulo mt-4 text-center"><?php echo esc_html( $tab['titulo'] ); ?></h3>
								<?php echo wp_kses_post( $tab['texto'] ); ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>