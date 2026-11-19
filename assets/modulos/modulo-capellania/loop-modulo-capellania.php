<section class="seccion" aria-labelledby="titulo-galeria">
    <div class="container">
        <div class="encabezado-seccion">
            <h2 id="titulo-galeria"><?php echo esc_html(get_field('titulo_seccion_2_capellania')); ?></h2>
            <p class="text-center"><?php echo esc_html(get_field('texto_seccion_2_capellania')); ?></p>
        </div>

        <?php if (function_exists('have_rows') && have_rows('galeria_capellania')): ?>
            <div class="galeria-mosaico" role="group"
                aria-label="<?php echo esc_attr(get_field('titulo_seccion_2_capellania')); ?>">
                <?php
                while (have_rows('galeria_capellania')):
                    the_row();

                    $imagen = get_sub_field('imagen_capellania');
                    $rotulo = get_sub_field('etiqueta_foto_capellania');
                    $descripcion = get_sub_field('descripcion_foto_capellania');
                    $class_special = (1 === get_row_index()) ? ' galeria-mosaico-pieza-descripcion' : '';
                    ?>

                    <figure class="galeria-mosaico-pieza<?php echo esc_attr($class_special); ?>"
                        data-rotulo="<?php echo esc_attr($rotulo); ?>" tabindex="0">
                        <?php if (is_array($imagen) && !empty($imagen['url'])): ?>
                            <img class="img-fluid" src="<?php echo esc_url($imagen['url']); ?>"
                                alt="<?php echo esc_attr(isset($imagen['alt']) && $imagen['alt'] ? $imagen['alt'] : $rotulo); ?>"
                                loading="lazy" decoding="async">
                        <?php endif; ?>
                        <figcaption class="galeria-mosaico-pie"><?php echo esc_html($descripcion); ?></figcaption>
                    </figure>

                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="seccion seccion-crema" aria-labelledby="titulo-calendario-liturgico">
    <div class="container">
        <div class="encabezado-seccion">
            <h2 id="titulo-calendario-liturgico"><?php echo esc_html(get_field('titulo_calendario_liturgico')); ?>
            </h2>
            <p class="text-center"><?php echo esc_html(get_field('texto_calendario_liturgico')); ?></p>
        </div>
    </div>
</section>

<?php if ( function_exists( 'have_rows' ) && have_rows( 'eventos_calendario_liturgico' ) ) : ?>
<section class="calendario-liturgico seccion-crema pb-5" role="group" aria-label="<?php echo esc_attr( get_field( 'titulo_calendario_liturgico' ) ); ?>">
	<div class="calendario-liturgico-linea" aria-hidden="true"></div>
	<div class="container calendario-liturgico-pista">
		<?php
		while ( have_rows( 'eventos_calendario_liturgico' ) ) :
			the_row();

			$titulo = get_sub_field( 'titulo_hito_liturgico' );

			// "false" devuelve el valor guardado (Ymd), sin depender del formato de retorno del campo.
			$inicio  = get_sub_field( 'fecha_inicio_liturgica', false );
			$termino = get_sub_field( 'fecha_termino_liturgica', false );

			$ts_inicio  = $inicio ? strtotime( $inicio ) : false;
			$ts_termino = $termino ? strtotime( $termino ) : false;

			$fecha_attr  = $ts_inicio ? date_i18n( 'Y-m-d', $ts_inicio ) : '';
			$fecha_texto = $ts_inicio ? date_i18n( 'j \d\e F', $ts_inicio ) : '';

			// Si hay rango (término distinto del inicio): "30 de marzo al 3 de abril".
			if ( $ts_inicio && $ts_termino && $ts_termino !== $ts_inicio ) {
				$fecha_texto .= ' al ' . date_i18n( 'j \d\e F', $ts_termino );
			}
			?>
			<article class="calendario-liturgico-hito">
				<div class="calendario-liturgico-tarjeta">
					<h3><?php echo esc_html( $titulo ); ?></h3>
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