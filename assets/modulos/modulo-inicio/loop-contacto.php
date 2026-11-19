<!-- 6. CONTACTO -->
<?php $mapa = get_field('contacto_mapa'); ?>
<section class="seccion seccion-crema" aria-label="Información de contacto y formulario">
	<div class="contenedor-contenido">
		<div class="row align-items-stretch">
			<div class="col-lg">
				<div class="bloque-contacto-informacion">
					<h3><?php echo $t('contacto_titulo'); ?></h3>
					<p><?php echo $t('contacto_texto'); ?></p>
					<h4><?php echo $t('contacto_ubicacion_titulo'); ?></h4>
					<p><?php echo $t('contacto_direccion'); ?></p>
					<img class="mapa-referencial" src="<?php echo $src($mapa); ?>"
						alt="<?php echo $alt($mapa); ?>" width="524" height="240">
					<h4><?php echo $t('contacto_consultas_titulo'); ?></h4>
					<p><?php echo $t('contacto_consultas_texto'); ?></p>
				</div>
			</div>

			<div class="col-lg-auto d-none d-lg-block">
				<div class="vr h-100"></div>
			</div>

			<div class="col-lg">
				<form class="formulario-contacto" action="<?php echo esc_url(admin_url('admin-post.php')); ?>"
					method="post">
					<input type="hidden" name="action" value="enviar_contacto">
					<?php wp_nonce_field('enviar_contacto', 'contacto_nonce'); ?>

					<div class="campo-formulario">
						<label class="form-label"
							for="nombre"><?php esc_html_e('Nombre completo', 'tu-tema'); ?></label>
						<input class="form-control" type="text" id="nombre" name="nombre"
							placeholder="<?php esc_attr_e('Tu nombre y apellido', 'tu-tema'); ?>"
							autocomplete="name" required>
					</div>

					<div class="campo-formulario">
						<label class="form-label"
							for="correo"><?php esc_html_e('Correo electrónico', 'tu-tema'); ?></label>
						<input class="form-control" type="email" id="correo" name="correo"
							placeholder="nombre@correo.cl" autocomplete="email" required>
					</div>

					<div class="campo-formulario">
						<label class="form-label"
							for="telefono"><?php esc_html_e('Teléfono de contacto (opcional)', 'tu-tema'); ?></label>
						<input class="form-control" type="tel" id="telefono" name="telefono"
							placeholder="+569 12345678" autocomplete="tel">
					</div>

					<div class="campo-formulario">
						<label class="form-label" for="asunto"><?php esc_html_e('Asunto', 'tu-tema'); ?></label>
						<select class="form-select" id="asunto" name="asunto" required>
							<option value="" selected><?php esc_html_e('Selecciona una opción', 'tu-tema'); ?>
							</option>
							<option value="conocer-hogar"><?php esc_html_e('Conocer el hogar', 'tu-tema'); ?>
							</option>
							<option value="visita"><?php esc_html_e('Consultar por una visita', 'tu-tema'); ?>
							</option>
							<option value="contribuir"><?php esc_html_e('Cómo contribuir', 'tu-tema'); ?>
							</option>
							<option value="otro"><?php esc_html_e('Otro', 'tu-tema'); ?></option>
						</select>
					</div>

					<div class="campo-formulario">
						<label class="form-label"
							for="mensaje"><?php esc_html_e('Tu mensaje', 'tu-tema'); ?></label>
						<textarea class="form-control" id="mensaje" name="mensaje" rows="5" required></textarea>
					</div>

					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="privacidad" name="privacidad"
							required>
						<label class="form-check-label" for="privacidad">
							<?php esc_html_e('Acepto la política de privacidad y el manejo de datos de la fundación.', 'tu-tema'); ?>
						</label>
					</div>

					<div class="d-flex justify-content-center">
						<button class="btn boton boton-primario"
							type="submit"><?php esc_html_e('Enviar mensaje', 'tu-tema'); ?></button>
					</div>
				</form>
			</div>

		</div>
	</div>
</section>