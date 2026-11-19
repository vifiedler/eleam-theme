<?php
$diapositivas = get_field( 'galeria_diapositivas' ) ?: array();
$total        = count( $diapositivas );
?>

<section class="seccion" aria-labelledby="titulo-galeria">
	<div class="container">
		<header class="encabezado-seccion">
			<h2 id="titulo-galeria"><?php echo esc_html( (string) get_field( 'galeria_titulo' ) ); ?></h2>
		</header>
		<?php if ( $total ) : ?>
			<div id="carrusel-infraestructura" class="carrusel-galeria" role="region" aria-roledescription="carrusel"
				aria-label="Galería de infraestructura">
				<div class="galeria-carrusel">
					<?php foreach ( $diapositivas as $i => $diapositiva ) : ?>
						<div class="galeria-carrusel-diapositiva" role="group" aria-roledescription="diapositiva"
							aria-label="<?php echo esc_attr( ( $i + 1 ) . ' de ' . $total ); ?>">
							<div class="galeria-mosaico">
								<?php
								$piezas = isset( $diapositiva['piezas'] ) && is_array( $diapositiva['piezas'] )
									? $diapositiva['piezas']
									: array();
								foreach ( $piezas as $j => $pieza ) :
									$imagen       = isset( $pieza['imagen'] ) && is_array( $pieza['imagen'] ) ? $pieza['imagen'] : array();
									$imagen_url   = isset( $imagen['url'] ) ? $imagen['url'] : '';
									$imagen_alt   = isset( $imagen['alt'] ) ? $imagen['alt'] : '';
									$clase_imagen = isset( $pieza['clase_imagen'] ) ? $pieza['clase_imagen'] : '';
									$rotulo       = isset( $pieza['rotulo'] ) ? $pieza['rotulo'] : '';
									$descripcion  = isset( $pieza['descripcion'] ) ? $pieza['descripcion'] : '';
									?>
									<figure class="galeria-mosaico-pieza<?php echo 0 === $j ? ' galeria-mosaico-pieza-descripcion' : ''; ?>"
										data-rotulo="<?php echo esc_attr( $rotulo ); ?>" tabindex="0">
										<img class="img-fluid<?php echo $clase_imagen ? ' ' . esc_attr( $clase_imagen ) : ''; ?>"
											src="<?php echo esc_url( $imagen_url ); ?>" alt="<?php echo esc_attr( $imagen_alt ); ?>"
											loading="lazy" decoding="async">
										<figcaption class="galeria-mosaico-pie"><?php echo esc_html( $descripcion ); ?></figcaption>
									</figure>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="carrusel-controles">
					<button class="carrusel-flecha carrusel-flecha-anterior" type="button" aria-label="Mosaico anterior">
						<span class="bi bi-arrow-left" aria-hidden="true"></span>
					</button>
					<div class="carrusel-posicion" aria-live="polite">
						<div class="carrusel-puntos" aria-hidden="true">
							<?php foreach ( $diapositivas as $i => $diapositiva ) : ?>
								<span<?php echo 0 === $i ? ' class="esta-activo"' : ''; ?>></span>
							<?php endforeach; ?>
						</div>
						<span class="carrusel-contador"><?php echo esc_html( '1 de ' . $total ); ?></span>
					</div>
					<button class="carrusel-flecha carrusel-flecha-siguiente" type="button" aria-label="Mosaico siguiente">
						<span class="bi bi-arrow-right" aria-hidden="true"></span>
					</button>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
