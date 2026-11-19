<?php
/**
 * The template for displaying the footer
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package eleam-theme
 */
?>

<footer id="colophon" class="pie-sitio">
	<div class="container-fluid contenedor-amplio">
		<div class="pie-sitio-rejilla">
			<div class="pie-sitio-columna pie-sitio-marca">
				<?php if ( is_active_sidebar( 'footer_1' ) ) : ?>
					<?php dynamic_sidebar( 'footer_1' ); ?>
				<?php else : ?>
					<?php
					$logo_adjunto = get_page_by_path( 'logo-eleam', OBJECT, 'attachment' );
					$logo_id = $logo_adjunto instanceof WP_Post ? (int) $logo_adjunto->ID : (int) get_theme_mod( 'custom_logo' );
					?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'ELEAM San Francisco, inicio', 'eleam-theme' ); ?>">
						<?php if ( $logo_id ) : ?>
							<?php echo wp_get_attachment_image( $logo_id, 'medium', false, array(
								'class' => 'img-fluid',
								'alt' => 'ELEAM San Francisco',
								'loading' => 'lazy',
								'decoding' => 'async',
							) ); ?>
						<?php else : ?>
							<span class="pie-sitio-marca-texto"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
						<?php endif; ?>
					</a>
				<?php endif; ?>
			</div>

			<?php if ( is_active_sidebar( 'footer_2' ) ) : ?>
				<div class="pie-sitio-columna">
					<?php dynamic_sidebar( 'footer_2' ); ?>
				</div>
			<?php else : ?>
				<div class="pie-sitio-columna">
					<h2><?php esc_html_e( 'Ubicación', 'eleam-theme' ); ?></h2>
					<address>Los Libertadores 234, El Monte. Región Metropolitana</address>
				</div>
			<?php endif; ?>

			<div class="pie-sitio-columna">
				<?php if ( is_active_sidebar( 'footer_3' ) ) : ?>
					<?php dynamic_sidebar( 'footer_3' ); ?>
				<?php else : ?>
					<h2><?php esc_html_e( 'Navegación', 'eleam-theme' ); ?></h2>
					<nav class="pie-sitio-navegacion" aria-label="<?php esc_attr_e( 'Navegación del pie', 'eleam-theme' ); ?>">
						<ul>
							<?php
							$paginas_footer = array(
								'quienes-somos' => __( '¿Quiénes somos?', 'eleam-theme' ),
								'infraestructura' => __( 'Infraestructura', 'eleam-theme' ),
								'actividades' => __( 'Actividades', 'eleam-theme' ),
								'capellania' => __( 'Capellanía', 'eleam-theme' ),
								'transparencia' => __( 'Transparencia', 'eleam-theme' ),
								'contacto' => __( 'Contacto', 'eleam-theme' ),
							);
							foreach ( $paginas_footer as $slug => $titulo ) :
								$pagina = get_page_by_path( $slug );
								if ( ! $pagina instanceof WP_Post ) {
									continue;
								}
							?>
								<li>
									<a href="<?php echo esc_url( get_permalink( $pagina ) ); ?>"
										<?php if ( is_page( $slug ) ) : ?>aria-current="page"<?php endif; ?>>
										<?php echo esc_html( $titulo ); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</nav>
				<?php endif; ?>
			</div>

			<?php if ( is_active_sidebar( 'footer_4' ) ) : ?>
				<div class="pie-sitio-columna">
					<?php dynamic_sidebar( 'footer_4' ); ?>
				</div>
			<?php else : ?>
				<div class="pie-sitio-columna">
					<h2><?php esc_html_e( 'Marco legal y calidad', 'eleam-theme' ); ?></h2>
					<div class="pie-sitio-legal">
						<a href="<?php echo esc_url( home_url( '/transparencia/' ) ); ?>">
							<?php esc_html_e( 'Ver informes y balances', 'eleam-theme' ); ?>
							<span class="bi bi-arrow-right" aria-hidden="true"></span>
						</a>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<div class="pie-sitio-creditos">
			<?php if ( is_active_sidebar( 'footer_5' ) ) : ?>
				<?php dynamic_sidebar( 'footer_5' ); ?>
			<?php else : ?>
				<p>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?>
					<?php esc_html_e( 'Diseñado por Adaby · Todos los derechos reservados.', 'eleam-theme' ); ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>