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
			<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
				<?php if ( is_active_sidebar( 'footer-' . $i ) ) : ?>
					<div class="pie-sitio-columna">
						<?php dynamic_sidebar( 'footer-' . $i ); ?>
					</div>
				<?php endif; ?>
			<?php endfor; ?>
		</div>

		<?php if ( is_active_sidebar( 'footer-creditos' ) ) : ?>
			<div class="pie-sitio-creditos">
				<?php dynamic_sidebar( 'footer-creditos' ); ?>
			</div>
		<?php endif; ?>

	</div>
</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>