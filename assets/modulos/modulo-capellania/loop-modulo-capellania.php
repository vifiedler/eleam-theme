<div class="container">
	<div class="encabezado-seccion">
		<h2 id="titulo-galeria"><?php echo esc_html( get_field( 'titulo_seccion_2_capellania' ) ); ?></h2>
		<p class="text-center"><?php echo esc_html( get_field( 'texto_seccion_2_capellania' ) ); ?></p>
	</div>

	<?php if ( function_exists( 'have_rows' ) && have_rows( 'galeria_capellania' ) ) : ?>
		<div class="galeria-mosaico" role="group" aria-label="<?php echo esc_attr( get_field( 'titulo_seccion_2_capellania' ) ); ?>">
			<?php
			while ( have_rows( 'galeria_capellania' ) ) :
				the_row();

				$imagen      = get_sub_field( 'imagen_capellania' );
				$rotulo      = get_sub_field( 'etiqueta_foto_capellania' );
				$descripcion = get_sub_field( 'descripcion_foto_capellania' );
				$class_special = ( 1 === get_row_index() ) ? ' galeria-mosaico-pieza-descripcion' : '';
				?>

				<figure class="galeria-mosaico-pieza<?php echo esc_attr( $class_special ); ?>" data-rotulo="<?php echo esc_attr( $rotulo ); ?>" tabindex="0">
					<?php if ( is_array( $imagen ) && ! empty( $imagen['url'] ) ) : ?>
						<img class="img-fluid"
							src="<?php echo esc_url( $imagen['url'] ); ?>"
							alt="<?php echo esc_attr( isset( $imagen['alt'] ) && $imagen['alt'] ? $imagen['alt'] : $rotulo ); ?>"
							loading="lazy" decoding="async">
					<?php endif; ?>
					<figcaption class="galeria-mosaico-pie"><?php echo esc_html( $descripcion ); ?></figcaption>
				</figure>

			<?php endwhile; ?>
		</div>
	<?php endif; ?>
</div>

<?php if ( have_rows( 'eventos_calendario_liturgico' ) ) : ?>
<section class="calendario-liturgico seccion-crema pb-5" role="group" aria-label="<?php echo esc_attr( get_field( 'calendario_etiqueta' ) ?: 'Hitos del calendario litúrgico' ); ?>">
	<div class="calendario-liturgico-linea" aria-hidden="true"></div>
	<div class="container calendario-liturgico-pista">
		<?php
		while ( have_rows( 'calendario_hitos' ) ) :
			the_row();

			$nombre      = get_sub_field( 'titulo_hito_liturgico' );
			$fecha_raw   = get_sub_field( 'fecha_inicio_liturgica', false ); // valor sin formatear (Ymd), no depende del formato de retorno
			$fecha_texto = get_sub_field( 'fecha_termino_liturgica' );

			$ts          = $fecha_raw ? strtotime( $fecha_raw ) : false;
			$fecha_attr  = $ts ? date_i18n( 'Y-m-d', $ts ) : '';
			$fecha_texto = $fecha_texto ?: ( $ts ? date_i18n( 'j \d\e F', $ts ) : '' );
			?>
			<article class="calendario-liturgico-hito">
				<div class="calendario-liturgico-tarjeta">
					<h3><?php echo esc_html( $nombre ); ?></h3>
				</div>
				<time datetime="<?php echo esc_attr( $fecha_attr ); ?>"><?php echo esc_html( $fecha_texto ); ?></time>
			</article>
		<?php endwhile; ?>
	</div>
	<div class="calendario-liturgico-controles" role="group" aria-label="Controles del calendario litúrgico">
		<button type="button" class="calendario-liturgico-control" data-calendario-accion="anterior"
			aria-label="Hito anterior">
			<i class="bi bi-chevron-left" aria-hidden="true"></i>
		</button>
		<button type="button" class="calendario-liturgico-control" data-calendario-accion="reproducir"
			aria-label="Reproducir calendario">
			<i class="bi bi-play-fill" aria-hidden="true"></i>
		</button>
		<button type="button" class="calendario-liturgico-control" data-calendario-accion="pausar"
			aria-label="Pausar calendario">
			<i class="bi bi-pause-fill" aria-hidden="true"></i>
		</button>
		<button type="button" class="calendario-liturgico-control" data-calendario-accion="siguiente"
			aria-label="Siguiente hito">
			<i class="bi bi-chevron-right" aria-hidden="true"></i>
		</button>
	</div>
</section>
<?php endif; ?>