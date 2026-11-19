<?php
/**
 * Detalle de un taller (entradas de la categoría "talleres").
 * Replica actividades-detalle.html.
 *
 * Grupo SCF "ELEAM | Detalle de talleres (entradas)":
 * - titulo_seccion_detalle_taller (texto)
 * - titulo_galeria_detalle_taller (texto)
 * - galeria_detalle_taller (repetidor)
 *   - foto_detalle_taller             (imagen, array)
 *   - rotulo_foto_detalle_taller      (texto)
 *   - descripcion_foto_detalle_taller (área de texto)
 *
 * Imagen destacada → hero y bloque de detalle. Extracto → bajada del hero.
 * Contenido de la entrada → texto del bloque de detalle.
 *
 * @package eleam-theme
 */

$titulo_detalle = get_field( 'titulo_seccion_detalle_taller' ) ?: __( 'Sobre el taller', 'eleam' );
$titulo_galeria = get_field( 'titulo_galeria_detalle_taller' ) ?: __( 'Galería del taller', 'eleam' );

// Galería: solo filas con foto, agrupadas de a 4 por mosaico.
$fotos = array_values(
	array_filter(
		get_field( 'galeria_detalle_taller' ) ?: array(),
		function ( $fila ) {
			return is_array( $fila['foto_detalle_taller'] );
		}
	)
);
$diapositivas = array_chunk( $fotos, 4 );
$total        = count( $diapositivas );
?>

<section class="hero-interior" aria-labelledby="titulo-pagina">
	<div class="container-fluid contenedor-amplio">
		<div class="row">
			<div class="col-md-6 hero-interior-texto">
				<h1 id="titulo-pagina"><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<p><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
			</div>
			<?php if ( has_post_thumbnail() ) : ?>
			<div class="col-md-6">
				<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid hero-interior-imagen' ) ); ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<section class="seccion-detalle-taller" aria-labelledby="titulo-detalle-taller">
	<div class="container">
		<header class="encabezado-seccion">
			<h2 id="titulo-detalle-taller"><?php echo esc_html( $titulo_detalle ); ?></h2>
		</header>

		<div class="d-flex flex-column flex-md-row align-items-start detalle-contenido">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'large', array( 'class' => 'detalle-imagen', 'loading' => 'lazy' ) ); ?>
			<?php endif; ?>
			<div class="detalle-texto">
				<?php the_content(); ?>
			</div>
		</div>
	</div>
</section>

<?php if ( $total ) : ?>
<section class="seccion-detalle-galeria" aria-labelledby="titulo-detalle-galeria">
	<h2 id="titulo-detalle-galeria" class="visually-hidden"><?php echo esc_html( $titulo_galeria ); ?></h2>
	<div class="container">
		<div id="carrusel-detalle" class="carrusel-galeria" role="region" aria-roledescription="carrusel" aria-label="<?php echo esc_attr( $titulo_galeria ); ?>">
			<div class="galeria-carrusel">
				<?php foreach ( $diapositivas as $i => $piezas ) : ?>
				<div class="galeria-carrusel-diapositiva" role="group" aria-roledescription="diapositiva" aria-label="<?php echo esc_attr( ( $i + 1 ) . ' de ' . $total ); ?>">
					<div class="galeria-mosaico">
						<?php
						foreach ( $piezas as $j => $pieza ) :
							$foto   = $pieza['foto_detalle_taller'];
							$rotulo = $pieza['rotulo_foto_detalle_taller'] ?: $foto['title'];
							$texto  = $pieza['descripcion_foto_detalle_taller'] ?: $rotulo;
							?>
						<figure class="galeria-mosaico-pieza<?php echo 0 === $j ? ' galeria-mosaico-pieza-descripcion' : ''; ?>" data-rotulo="<?php echo esc_attr( $rotulo ); ?>" tabindex="0">
							<img class="img-fluid" src="<?php echo esc_url( $foto['url'] ); ?>" alt="<?php echo esc_attr( $foto['alt'] ?: $rotulo ); ?>" loading="lazy" decoding="async">
							<figcaption class="galeria-mosaico-pie"><?php echo esc_html( $texto ); ?></figcaption>
						</figure>
						<?php endforeach; ?>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<div class="carrusel-controles">
				<button class="carrusel-flecha carrusel-flecha-anterior" type="button" aria-label="Mosaico anterior"><span class="bi bi-arrow-left" aria-hidden="true"></span></button>
				<div class="carrusel-posicion" aria-live="polite">
					<div class="carrusel-puntos" aria-hidden="true">
						<?php for ( $i = 0; $i < $total; $i++ ) : ?>
							<span<?php echo 0 === $i ? ' class="esta-activo"' : ''; ?>></span>
						<?php endfor; ?>
					</div>
					<span class="carrusel-contador"><?php echo esc_html( '1 de ' . $total ); ?></span>
				</div>
				<button class="carrusel-flecha carrusel-flecha-siguiente" type="button" aria-label="Mosaico siguiente"><span class="bi bi-arrow-right" aria-hidden="true"></span></button>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
